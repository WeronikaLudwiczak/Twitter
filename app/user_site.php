<?php
use src\classes\User  as User;
use src\classes\Comment as Comment;
use src\classes\Tweet as Tweet;


require_once 'dbConnection.php';
redirectIfNotLogged();


if (isset($_SESSION['loggedUserId'])) {
    $loggedUser = User::loadUserById($conn, $_SESSION['loggedUserId']);
} else {
    echo "Error. Please log In again.";
}
?>

<html>
    <head>
        <title>Your Profile</title>
        <meta charset="UTF-8">
        <link <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/lumen/bootstrap.min.css">
    </head>
    <body>
        <p>Logged as: <a href="#" class="btn btn-link"><?php echo $loggedUser->getUsername(); ?></a></p>

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Home Page</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li ><a href="user_edit.php">Edit Your Profile</a></li>
                        <li><a href="send_message.php">Messages</a></li>
                        <li><a href="all_users.php">Users</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href='logout.php'>Log Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="well" style='width: 25%'>
            <h3>Profile details: </h3>
            <p><strong>Email Adress:</strong> <?php echo $loggedUser->getEmail(); ?></p>
            <p><strong>User Name: </strong><?php echo $loggedUser->getUsername(); ?></p>
        </div>

        <h2 class="text-primary">Your Tweets</h2>
        <table class="table table-striped table-hover ">
            <thead>
                <tr>

                    <th>Date</th>
                    <th>Tweet</th>
                    <th>Comments</th>
                    <th>Action</th>
            </thead>
<?php
$userId = $loggedUser->getId();
$allUserTweets = Tweet::loadAllTweetByUserId($conn, $userId);

if ($allUserTweets) {
    foreach ($allUserTweets as $tweet) {
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

