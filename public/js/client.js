

let userIdElement,
    usernameElement,
    roomIdElement,
    user2IdElement,
    user_id,
    username,
    room_id;    
                

    user_id = $("#user_id").attr("data-val");
    username = $("#username").attr("data-val");

// , {'sync disconnect on unload' : false}
let socket = io.connect('https://chat-app-m5g2.onrender.com:8081');

// socket.on('connect', function(){
//     console.log("Connected")
//     socket.emit("getUserInfo", {user_id, username});
// });

// MANCAO : 192.168.56.1
// HOME :   192.168.254.110
// CP   :   192.168.142.7

document.addEventListener('DOMContentLoaded', () => {
    if($('title').text() == "Chat"){
        userIdElement = document.getElementById("user_id");
        usernameElement = document.getElementById("username");
        roomIdElement = document.getElementById("room_id");
        user2IdElement = document.getElementById("user2_id");
            
        if(user2IdElement) user_id = userIdElement.getAttribute("data-val");
        if(usernameElement) username = usernameElement.getAttribute("data-val");
        if(roomIdElement) room_id = roomIdElement.getAttribute("data-val");
    }
    
    if($('title').text() == "Home"){
        socket.emit("user_left", {user_id});
    }


    if($('title').text() == "Finding"){
        findMatch();
    }

    socket.on("found_match", (data) => {
        foundMatch(data);
    })
    
    socket.on('connect', function(){
        console.log("Connected");

        socket.emit("getUserInfo", {user_id, username});
    });

    socket.on("update_chat", (roomId) => {
        if (roomId != room_id) return;

        getLastChat();
    })


    socket.on("user_left", (data) => {
        user2_id = $("#user2_id").attr("data-val");
        if(data.user_id != user2_id) return;

        updateChat();
        user2Left();
    })


    $("#random_chat").on("click", function(){
        $.ajax({
            url: "../controls/find.cntrl.php",
            type: "POST",
            data: {random : true},
            success: function(){
                findMatch();
                window.location.href = "../views/find.view.php";
            }
        })
    })


    socket.on("follow_request", (data) => {
        if (data.receiver_id != user_id) return;
        Swal.fire({
            title: data.sender.username + " has sent you a follow request.",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Accept",
            denyButtonText: `Decline`
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                socket.emit("followed", {
                    user_id: data.sender.user_id,
                    room_id
                });

                $("#add_btn").remove();
                Swal.fire("You are now friends with " + data.sender.username + "!", "", "success");
            } else if (result.isDenied) {
                Swal.fire("Request denied!", "", "info");
            }
        });

    })

    socket.on("follow_accepted", (data) => {
        if (data.room_id != room_id) return;
        if (data.user_id != user_id) return;

        $("#add_btn").remove();
        Swal.fire("Your follow request has been accepted!", "", "success");
    })



    // FOLLOW USER REQUEST
    $("#add_btn").on("click", function () {
        let user2_id = user2IdElement.getAttribute("data-val");
        socket.emit("follow_request", {
            sender: {
                user_id,
                username
            },
            receiver_id: user2_id,
            room_id
        })
        Swal.fire({
            position: "center",
            toast: true,
            icon: "success",
            title: "Follow request has been sent succesfull!",
            showConfirmButton: false,
            timer: 1500
        });
    })


// BACK BUTTON - USER WANTS TO LEAVE
    $('#back_btn').on("click", function(){
        
        socket.emit("user_left", {user_id});
        window.location.href = "../views/home.view.php";
    })

    // CHATTING FUNCTION
    $('.message-container').on("submit", function (e) {
        e.preventDefault()

        message_box = $(".message-box");
        send_btn = $(".send-btn");
        let message = $(".message-box").val();

        if(send_btn.val() == "Find"){
            findMatch();
            window.location.href = "../views/find.view.php";
        }

        if (message == "") return;

        $.ajax({
            url: "../controls/chats.cntrl.php",
            type: "POST",
            data: {
                message
            },
            success: function (data) {
                message_box.val("");
                socket.emit("update_chat", room_id);
            }
        })
    });

    // USER2 LEFT UNABLES TO CHAT
    function user2Left(){
        let isFollowed = $("#is_followed").attr("data-val");

        if(isFollowed === "Followed") return;

        message_box = $(".message-box");
        send_btn = $(".send-btn");

        message_box.prop("disabled", true);
        send_btn.prop("value", "Find");

    }

    // MISC FUNCTION
    function scrollToBottom() {
        let chatbox = document.getElementById("chatbox");
        if (!chatbox) return;

        chatbox.scrollTop = chatbox.scrollHeight;
    }

    function updateChat() {
        $.ajax({
            url: "../controls/chats.cntrl.php",
            success: function (data) {
                $('.chat-container').html(data);
                scrollToBottom();
            }
        })
    }

    function getLastChat(){

        $.ajax({
            url: "../controls/chats.cntrl.php",
            type: "POST",
            data: {getLastChat : "true"},
            success: function(data){
                $('.chat-container').append(data)
                scrollToBottom();
            }
        })
    }


    function findMatch() {
        socket.emit("find_match", user_id);
    }


    function foundMatch(data) {
        $.ajax({
            url: "../controls/find.cntrl.php",
            type: "POST",
            data: {
                room_id: data.chatroom_id
            },
            success: function (data) {
                if (data == "found") {
                    window.location.href = "../views/chat.view.php";
                }
            }
        })

    }

    updateChat();
});