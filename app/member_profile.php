<?php
require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once 'dbConnection.php';

redirectIfNotLogged();

if (isset($_SESSION['loggedUserId'])) {
    $loggedUser = User::loadUserById($conn, $_SESSION['loggedUserId']);
} else {
    echo "Error. Please log In again.";
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' and isset($_GET['user'])) {
    $memberId = $_GET['user'];
    $member = User::loadUserById($conn, $memberId);
}
?>
<html>
    <head>
        <title><?php echo "{$member->getUsername()}" ?> Profile</title>
        <meta charset="UTF-8">
        <link href="../css/style.css" rel="stylesheet">
    </head>
    <body>
        <p>Logged as: <a href="user_site.php" class="btn btn-link"><?php echo $loggedUser->getUsername(); ?></a></p>

        <?php
        include "menu.html";
        ?>


        <div class="well" style='width: 25%'>
            <h3>Profile details: </h3>
            <p><strong>Email Adress:</strong> <?php echo $member->getEmail(); ?></p>
            <p><strong>User Name: </strong><?php echo $member->getUsername(); ?></p>
        </div>

        <h2 class="text-primary"> Tweets</h2>
        <table class="table table-striped table-hover ">
            <thead>
                <tr>

                    <th>Date</th>
                    <th>Tweet</th>
                    <th>Comments</th>
                    <th>Action</th>
            </thead>
            <?php
            $memberId = $_GET['user'];
            $allMemberTweets = Tweet::loadAllTweetByUserId($conn, $memberId);

            if ($allMemberTweets) {
                foreach ($allMemberTweets as $tweet) {
                    $comments = Comment::getCommentByTweetId($conn, $tweet->getId());
                    if ($comments !== false) {
                        $numberOfComments = count($comments);
                    } else {
                        $numberOfComments = 0;
                    }
                    ?>  
                    <tbody>
                        <tr class="active">
                            <td><?php echo "{$tweet->getCreationDate()}"; ?></td>
                            <td><?php echo "{$tweet->getText()}"; ?></td>
                            <td><?php echo "$numberOfComments"; ?></td>
                            <td><?php echo ("<a class='btn btn-link' href='tweet_site.php?tweet_id={$tweet->getId()}'>More about Tweet</a>"); ?></td>
                        </tr>
                        <?php
                    }
                }
    
$conn->close();
$conn = null;

