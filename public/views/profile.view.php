<?php
include_once "../projects.all.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
}

if (isset($_SESSION['followed_id'])) {
    unset($_SESSION['followed_id']);
}

$currentUser = $_SESSION['user'];
$userWithCoins = $user_handler->getUserWithCoins($currentUser['id']);
$userInboxLimit = $user_handler->getUserInboxLimit($currentUser['id']);

$limit = isset($userInboxLimit['inbox_limit']) ? $userInboxLimit['inbox_limit'] : '?';
$coins = isset($userWithCoins['coins']) ? $userWithCoins['coins'] : 0;
$followed_users = $user_handler->getFollowedUsers($currentUser['id']);

$inboxLimit = $limit;
$inboxCount = count($followed_users);

// sure nga int
$inboxLimit = is_numeric($inboxLimit) ? (int)$inboxLimit : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>

<body>
    <div class="header box h gap-l space-between">
        <div class="box h gap-s align-center">
            <div class="box v panel-primary">
                <h2 class="text-big-header light">Chat</h2>
            </div>
            <span class="text-secondary">The Alliance of Coders</span>
        </div>
        <div class="box h gap-s">

            <div class="box h gap-m s panel-accent-2 align-center">
                <i class="fa-solid fa-coins fa-lg" style="color: #fafafa;"></i>
                <span class="text-secondary light"></span>
                <?= htmlspecialchars($coins); ?></span>
            </div>

            <div class="box v panel-secondary m gap-m">
                <?= htmlspecialchars($currentUser['username']); ?>
            </div>

            <a href='../logout.php'>
                <div class="box h panel-negative m">Logout</div>
            </a>
        </div>
    </div>
    <div class="form-container">

        <div class="form-box">
            <div class="flex sp-b">
                <h2>Chats</h2>
                <span>Limit: <?= $inboxCount ?>/<?= $inboxLimit ?></span>
                <a href="settings.view.php">Settings</a>
            </div>
            <br>
            <div class="conv-container">
                <div class="conv-list">
                    <?php if ($inboxCount >= $inboxLimit): ?>
                        <div style="color: red; font-weight: bold; text-align:center;">You have reached your inbox limit!</div>
                    <?php endif; ?>

                    <?php 
                        // $followed_user = array_slice($followed_users, 0, $inboxLimit); 
                        foreach ($followed_users as $followed_user):
                            $room_id = $followed_user['room_id'];
                            $followed_user = $followed_user['user'];
                            $room = $user_handler->getRoom($room_id);
                            $user2 = $user_handler->getUser($followed_user["id"]);

                            $last_msg = $user_handler->getLastChat($room_id);
                    ?>
                        <div class="convo">
                            <div class="up">
                                <input type="hidden" name="room_id" id="room_id" value="<?= $room_id?>">
                                <h4><?= htmlspecialchars($user2['username']) ?></h4>
                                <h5> <?= date("F d", strtotime($last_msg['timestamp']))?></h5>
                            </div>
                            <div class="bottom">
                                <span class="last-msg"><strong><?= ($last_msg['sender_id'] == $followed_user["id"]) ? $user2['username'] : "You" ?> : </strong> <?= $last_msg['message'] ?></span>
                                <b class="time-sent"><?= date("h:i A", strtotime($last_msg['timestamp']))?></b>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>

                </div>
            </div>
        </div>
    </div>

    
    <input type="hidden" id="user_id" data-val="<?= $currentUser['id'] ?>">
    <input type="hidden" id="username" data-val="<?= $currentUser['username'] ?>">

    <script src="../js/client.js"></script>
    <script src="../js/local.js"></script>

    <?php
    include_once "../components/navigation.cmp.php";
    ?>
</body>

</html>