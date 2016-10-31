<?php

require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once '../src/Comment.php';
require_once 'dbConnection.php';
redirectIfNotLogged();


if (isset($_SESSION['loggedUserId'])) {
    $loggedUser = User::loadUserById($conn,$_SESSION['loggedUserId']);  

    
}else {
   echo "Error. Please log In again.";
  
}

if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['newTweet'])) {
    if( strlen($_POST['newTweet']) > 0){
    
  $date=date('Y-m-d h:i:s');
  $newTweet= new Tweet();
  $newTweet->setUserId($loggedUser->getId());
  $newTweet->setText($_POST['newTweet']);
  $newTweet->setCreationDate($date);
  $newTweet->saveToDB($conn);
  
    }else{
    echo ('<div class="alert alert-dismissible alert-info">Write your Tweet</div>');
    }
}

?>

<html>
<head>
    <title>Home Page</title>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <p>Logged as: <a href="#" class="btn btn-link"><?php echo $loggedUser->getUsername();?></a></p>
    
<?php
include 'menu.html';
?>
    
    
 <section>
        <div class="container">
            <form  method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Write your Tweet:</label>
                    <div class="col-sm-7 form-group">
                        <input  class="form-control" type="text" name="newTweet"  style="height: 100px">        
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3">
                        <button type="submit" class="btn btn-default">Ćwierknij</button>
                    </div>
                </div>

            </form>
        </div>
     <br>
 </section>
    <h2 class="text-primary">All Tweets</h2>
    <table class="table table-striped table-hover ">
  <thead>
    <tr>
     
      <th>Date</th>
      <th>User</th>
      <th>Tweet</th>
      <th>Comments</th>
      <th>Action</th>
  </thead>
    <?php
  
  $allTweets = Tweet::loadAllTweets($conn);
if($allTweets){
    foreach($allTweets as $tweet){
                $userId = $tweet->getUserId();
                $user=  User::loadUserById($conn, $userId);
                $comments= Comment::getCommentByTweetId($conn, $tweet->getId());
                if($comments !==false){
                $numberOfComments=  count($comments);
                }else{
                    $numberOfComments=0;
                }
                ?>

  <tbody>
    <tr class="active">
      <td><?php echo "{$tweet->getCreationDate()}";?></td>
      <td><?php echo "{$user->getUsername()}";?></td>
      <td><?php echo "{$tweet->getText()}";?></td>
      <td><?php echo "$numberOfComments";?></td>
      <td><?php echo ("<a  href='tweet_site.php?tweet_id={$tweet->getId()}' class='btn btn-link' >More about Tweet</a></td>");?>    </tr>
   
               <?php
               
    }
    }else{
        echo "No Tweets";
}
?>

  
    <section>
        
    </section>
    
</body>
</html>
<?php
$conn->close();
$conn = null;