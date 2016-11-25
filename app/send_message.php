<?php
require_once "../src/User.php";
require_once "../src/Message.php";

require_once 'dbConnection.php';

redirectIfNotLogged();

if (isset($_SESSION['loggedUserId'])) {
    $loggedUser = User::loadUserById($conn, $_SESSION['loggedUserId']);
} else {
    echo "Error. Please log In again.";
}
if( isset($_GET['userId'])){
    $addresserId=$_GET['userId'];
    $addresser=  User::loadUserById($conn,$addresserId );
    
//    var_dump($addresser);
    }



?>

<html>
<head>
    <title>Send Message</title>
    <meta charset="UTF-8">
    <link <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/lumen/bootstrap.min.css">
</head>
<body>
    <p>Logged as: <a href="#" class="btn btn-link"><?php echo $loggedUser->getUsername();?></a></p>
    
<?php
include 'menu.html';
?>
   
    <div class="container">
        <div class="row">
            <?php
                if(isset($addresser)) {
                    if ($addresser->getId() == $loggedUser->getId()) {
                        echo ('You can not send a message to yourself');
                    } else {
                        echo "<h2>To: " . $addresser->getUsername() . "</h2>";
                        echo '<form class="form-horizontal" action="#" method="post">
                            <label class="col-sm-3 control-label">Your Message:</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="newMessage">
                           </div>
                           <button type="submit" class="btn btn-default">Send</button>
                           </form>';
                    }
                }
                ?>
 </div>
    </div><br><br>
    <div class="container">
            <?php
            if($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['newMessage'])){
    

    
    $newMessage= new Message();
    $date=  date('Y-m-d h:i:s');
    
    $newMessage->setAddresserId($addresser->getId());
    $newMessage->setSenderId($loggedUser->getId());
    $newMessage->setCreationDate($date);
    $newMessage->setText($_POST['newMessage']);
    $newMessage->setIfRead(1);
    $newMessage->saveToDB($conn);
    header("Location:messages_site.php");
    
    
}

    ?>
    </div>
</section>


</body>
</html>


<?php
$conn->close();
$conn = null;
?>