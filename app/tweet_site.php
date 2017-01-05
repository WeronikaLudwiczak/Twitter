<?php
use src\classes\User as User;
use src\classes\Comment as Comment;
use src\classes\Tweet as Tweet;


require_once 'dbConnection.php';

redirectIfNotLogged();


if (isset($_SESSION['loggedUserId'])) {
    $loggedUser = User::loadUserById($conn, $_SESSION['loggedUserId']);
} else {
    echo "Error. Please log In again.";
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['new_comment']) && strlen($_POST['new_comment']) > 0) {
    $date = date('Y-m-d h:i:s');
    $tweet_id = $_GET['tweet_id'];
    $newComment = new Comment();
    $newComment->setCreationDate($date);
    $newComment->setText($_POST['new_comment']);
    $newComment->setTweetId($_GET['tweet_id']);
    $newComment->setUserId($_SESSION['loggedUserId']);
    $newComment->saveToDB($conn);
    header("Location: tweet_site.php?tweet_id={$tweet_id}");
}
?>


<html>
<head>
    <title>Tweet Page</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/lumen/bootstrap.min.css">
</head>
<body>
<p>Logged as: <a href="user_site.php" class="btn btn-link"><?php echo $loggedUser->getUsername(); ?></a></p>

<?php
include 'menu.html';

?>
<h3>Tweet details: </h3>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tweetId = $_GET['tweet_id'];
    $tweet = Tweet::loadTweetById($conn, $tweetId);
    $userId = $tweet->getUserId();
    $userTweet = User::loadUserById($conn, $userId);


    echo "<p><strong>Creation date: </strong>" . $tweet->getCreationDate() . "</p>";
    echo "<p><strong>User Name: </strong>" . $userTweet->getUsername() . "</p>";
    echo '
        <div class="well" style="width: 50%">
            <p><strong>Tweet: </strong>' . $tweet->getText() . '</p>
        </div>';
    ?>
    <section>
        <div class="container">
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Write your Comment:</label>
                    <div class="col-sm-7 form-group">
                        <input class="form-control" type="text" name="new_comment" style="height: 100px">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>

            </form>
        </div>
        <br>
    </section>
    <?php

    $comments = Comment::getCommentByTweetId($conn, $tweetId);
    if ($comments !== false) {
        $numberOfComments = count($comments);
    } else {
        $numberOfComments = 0;
    }

    echo '
    </section>
    <h2 class="text-primary">Comments (' . $numberOfComments . ')</h2>
    <table class="table table-striped table-hover ">
        <thead>
            <tr>

                <th>Date</th>
                <th>User</th>
                <th>Comments</th>
               
        </thead>';

    if ($comments) {
        foreach ($comments as $comment) {
            $userCommentId = $comment->getUserId();
            $userCommnet = User::loadUserById($conn, $userCommentId);

            echo '
                   <tbody>
                    <tr class="active">';
            echo "<td>{$comment->getCreationDate()}</td>";
            echo "<td>{$userCommnet->getUsername()}</td>";
            echo "<td>{$comment->getText()}</td>";
        }
    } else {
        echo "no Commnets";
    }
}
?>

</body>
</html>


<?php
$conn->close();
$conn = null;
?>






