<?php

require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once 'dbConnection.php';
redirectIfNotLogged();


if (isset($_SESSION['loggedUserId'])) {
    $loggedUser = new User();
    $loggedUser->loadUserById($conn, $_SESSION['loggedUserId']);
} else {
   echo "Error. Please log In again.";
}
if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['newTweet']) && strlen($_POST['newTweet']) > 0){
    
//  $date=date('Y-m-d h:i:s');
  $newTweet= new Tweet();
  $newTweet->setUserId($loggedUser->getId());
  $newTweet->setText($_POST['newTweet']);
//  $newTweet->setCreationDate($date);
  $newTweet->saveToDB($conn);
  
}
?>


 <section>
        <div class="container">
            <form  method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Write your Tweet:</label>
                    <div class="col-sm-7 form-group">
                        <input class="form-control" type="text" name="newTweet">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3">
                        <button type="submit" class="btn btn-default">Add your Tweet</button>
                    </div>
                </div>

            </form>
        </div>
    </section>