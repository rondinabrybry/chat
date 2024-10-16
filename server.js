// server.js
const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const cors = require('cors');
const mysql = require('mysql2/promise');

const app = express();
const server = http.createServer(app);
const io = socketIo(server, {
    cors: {
        origin: "*", // Allow connections from any origin
        methods: ["GET", "POST"]
    }
});

const PORT = process.env.PORT || 8081;

const HOST = 'localhost';
const PASSWORD = "AllianceOfCoders2024";
const USER = 'u132092183_aoc';
const DATABASE = "u132092183_aoc";

// Middleware to enable CORS for HTTP requests
app.use(cors({
    origin: "*", // Allow connections from any origin
}));

io.on('connection', (socket) => {
    let user_id, username;
    let room_id;

    socket.on('getUserInfo', (data) => {
        user_id = data.user_id;
        username = data.username;
        
        setStatus(user_id, true);
        console.log(username + " has connected.");
    })

    socket.on('update_chat', (data) => {
        room_id = data;
        io.emit('update_chat', data);
    })

    socket.on('find_match', (client_id) => {
        console.log(username + " is finding match..");

        result = getWaitinglist(client_id);

        console.log(result);

        if (!Number.isInteger(result)) return;

        room_id = result;
        console.log("ROOM MATCHED ID: " + room_id);

    })

    socket.on('disconnect', () => {
        setStatus(user_id, false)
        console.log("UserID: " + username + " has disconnected");
        removeWaitingList(user_id);

        if(!room_id) return;
        userLeft({user_id});
        console.log("RoomID: " + room_id + " has been closed.")
    });

    socket.on('user_left', (data) => {

        userLeft({user_id});
        removeWaitingList(user_id);
    })

    socket.on("follow_request", (data) => {
        io.emit("follow_request", data);
    })


    socket.on("followed", (data) => {
        followRoom(data);
    })

});

server.listen(PORT, '0.0.0.0', () => {
    console.log(`WebSocket server is running on http://0.0.0.0:${PORT}`);
});






// -------------------- CUSTOM FUNCTIONS --------------------------

// Following each other
async function followRoom(data) {
    let connection;
    try {
        connection = await getDatabase();
        await connection.execute("INSERT IGNORE INTO followed (chatroom_id) VALUES (?)", [data.room_id]);
        await connection.execute("UPDATE `chatroom` SET `isFollowed` = '1'WHERE `chatroom`.`id` = ?;", [data.room_id]);
        await connection.end();

        console.log("FOLLOWED!")
        io.emit("follow_accepted", data);
    } catch (err) {
        console.error("FOLLOWED REMOVAL ERROR OCCURED: ", err);
    } finally {
        if (connection) await connection.end();
    }
}



//User has left the conversation
async function removeWaitingList(user_id) {
    let connection;
    if (user_id == null) return;

    try {
        connection = await getDatabase();

        await connection.execute("DELETE FROM waitlist WHERE `finder_id` = ?", [user_id]);

        await connection.end();
    } catch (err) {
        console.error("WAITINGLIST REMOVAL ERROR OCCURED: ", err);
    } finally {
        if (connection) await connection.end();
    }
}


async function userLeft(data){

    let connection;
    if(data.user_id == null) return;
    
    try{
        console.log("UserID: " + data.user_id + " has left the conversation")
        connection = await getDatabase();

        await connection.execute("UPDATE `chatroom` SET `isActive` = '0', `user_left` = ? WHERE (userid_1 = ? OR userid_2 = ?) AND `isActive` = 1 AND `isFollowed` = 0;", [data.user_id, data.user_id, data.user_id]);
        console.log("A conversation was closed by " + data.user_id);
        io.emit('user_left', data);
    } catch (err) {
        console.error("LEFT ERROR OCCURED: ", err);
    } finally {
        if (connection) await connection.end();
    }
}


// Creates a chatroom for user 1 and user 2 and redirects them both to the chatroom
async function Match(user_1, user_2, isPreferred) {
    let connection;
    try {
        connection = await getDatabase();

        await connection.execute("DELETE FROM waitlist WHERE finder_id = ? or finder_id = ?", [user_1, user_2]);
        const [result] = await connection.execute("INSERT INTO chatroom (userid_1, userid_2) VALUES (?, ?)", [user_1, user_2]);

        chatroom_id = result.insertId;

        // Sends a signal that match has been found
        io.emit("found_match", {
            chatroom_id,
            isPreferred
        });

        await connection.end();
        return chatroom_id;
    } catch (err) {
        console.error("MATCH ERROR OCCURED: ", err);
    } finally {
        if (connection) await connection.end();
    }
}



async function checkFollowedUsers(user1_id, user2_id) {

    let connection;
    try {
        connection = await getDatabase();

        const [rows, fields] = await connection.execute("SELECT * FROM followed INNER JOIN chatroom ON chatroom.id = chatroom_id WHERE userid_1 = ? OR userid_2 = ?", [user1_id, user1_id]);

        let found = false;

        await rows.forEach(async (row) => {
            if (user2_id == row.userid_1 || user2_id == row.userid_2) {
                found = true;
            }
        })

        await connection.end();
        return found;

    } catch (err) {
        console.error("CHECKFOLLOWEDUSERS ERROR OCCURED: ", err);
    } finally {
        if (connection) await connection.end();
    }
}


//Checks if there are others that are waiting.
async function getWaitinglist(id) {
    let connection;
    try {
        let finder = await getFinderDetails(id);

        if (!finder) return;

        if (finder.preferred == null) {
            chatroom_id = await getRandomWaitingList(id);

            return chatroom_id;
        }

        connection = await getDatabase();

        sql = 'SELECT * FROM waitlist LEFT JOIN profile ON finder_id = user_id WHERE finder_id != ? AND gender = ? AND (preferred = ? OR preferred IS NULL)';
        const [rows, fields] = await connection.execute(sql, [id, finder.preferred, finder.gender]);
        await connection.end();

        if (rows.length > 0) {
            let user2_id;

            for (i = 0; i < rows.length; i++) {
                let row = rows[i];

                if (!await checkFollowedUsers(id, row.finder_id)) {
                    console.log("AVAILABLE")
                    user2_id = row.finder_id;

                    isPreferred = true;
                    chatroom_id = await Match(id, user2_id, isPreferred);
                    console.log("MATCHED ROOM ID: " + chatroom_id);
                    return chatroom_id;
                } else {
                    console.log("ALREADY FOLLOWED");
                }
            }
        }
    } catch (err) {
        console.error("WAITINGLIST ERROR OCCURED: ", err);
    } finally {
        if (connection) await connection.end();
    }
}


async function getRandomWaitingList(id) {
    let connection;

    try {
        let user = await getFinderDetails(id);
        connection = await getDatabase();

        sql = 'SELECT * FROM waitlist LEFT JOIN profile ON finder_id = user_id ' +
            'WHERE (finder_id != ? AND preferred = ?) OR (finder_id != ? AND preferred IS NULL)';

        const [rows, fields] = await connection.execute(sql, [id, user.gender, id]);
        await connection.end();

        if (rows.length > 0) {
            let user2_id;

            for (i = 0; i < rows.length; i++) {
                let row = rows[i];

                if (!await checkFollowedUsers(id, row.finder_id)) {
                    console.log("AVAILABLE")
                    user2_id = row.finder_id;

                    isPreferred = false;
                    chatroom_id = await Match(id, user2_id, isPreferred);
                    console.log("MATCHED ROOM ID: " + chatroom_id);

                    return chatroom_id;
                } else {
                    console.log("ALREADY FOLLOWED");
                }
            }
        }

    } catch (err) {
        console.error("RANDOMWAITINGLIST ERROR OCCURED: ", err);
    } finally {
        if (connection) await connection.end();
    }
}


async function getFinderDetails(finder_id) {
    let connection;
    try {
        connection = await getDatabase();

        sql = "SELECT * FROM waitlist INNER JOIN profile ON finder_id = user_id WHERE finder_id = ?";
        params = [finder_id];
        const [rows, fields] = await connection.execute(sql, params);

        if (rows.length > 0) {

            await connection.end();
            return rows[0];
        }
        await connection.end();
        return false;

    }catch(err){
        console.error("GETFINDERDETAILS ERROR OCCURED: ", err);
    }finally{
        if(connection) await connection.end();
    }
}


async function setStatus(user_id, isOnline){
    let connection;
    try{
        connection = await getDatabase();

        if(isOnline){
            await connection.execute("UPDATE profile SET status = ? WHERE user_id = ?", ["Online", user_id]);
        }else{
            await connection.execute("UPDATE profile SET status = ? WHERE user_id = ?", ["Offline", user_id]);
        }

        await connection.end();
    }catch(err){
        console.error("GETFINDERDETAILS ERROR OCCURED: ", err);
    }finally{
        if(connection) await connection.end();
    }
}


async function getDatabase() {
    const connection = await mysql.createConnection({
        host: HOST,
        user: USER,
        password: PASSWORD,
        database: DATABASE
    });

    return connection;
}