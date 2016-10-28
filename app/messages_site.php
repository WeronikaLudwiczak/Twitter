<?php
//require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once '../src/Message.php';
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
        <title>Messages</title>
        <meta charset="UTF-8">
        <link href="../css/style.css" rel="stylesheet">
    </head>
    <body>
        <p>Logged as: <a href="#" class="btn btn-link"><?php echo $loggedUser->getUsername(); ?></a></p>

<?php
include 'menu.html';
?>
        <section>
            <div class="container">
                <table class="table"><br>
                    <h2>Received:</h2><br>
                    <thead>
                        <tr>
                            <th>Sender:</th>
                            <th>Message:</th>
                            <th>Answer:</th>
                            <th>Date:</th>
                            <th>Status:</th>
                        </tr>
                    </thead>
                    <tbody>

<?php
$recivedMessages = Message::loadCommentsByAddresserId($conn, $loggedUser->getId());

foreach ($recivedMessages as $recivedMessage) {

    echo '<tr>';

    $sender = User::loadUserById($conn, $recivedMessage->getSenderId());
    echo "<td>{$sender->getUsername()}</td>";
    echo "<td>". substr($recivedMessage->getText(),0,60)."</td>";
     if(strlen($recivedMessage->getText()) > 60){
                    echo "...";
                }
    
    echo "<td><a href='send_message.php?userId={$recivedMessage->getAddresserId()}'>Send Message</td>";
    echo "<td>{$recivedMessage->getCreationDate()}<td>";

    if ($recivedMessage->getIfRead() == 1) {
        echo "READ";
    }
}
?>

                    </tbody>
                </table>
<table class="table"><br>
                    <h2>Sent:</h2><br>
                    <thead>
                        <tr>
                            <th>Addresser:</th>
                            <th>Message:</th>
                            <th>Date:</th>
                        </tr>
                    </thead>
                 <tbody>
<?php

$sentMessaages= Message::loadCommentsBySenderId($conn, $loggedUser->getId());

foreach($sentMessaages as $sentMessage){
    
        echo '<tr>';

    $receiver = User::loadUserById($conn, $sentMessage->getAddresserId());
    echo "<td>{$receiver->getUsername()}</td>";
    echo "<td>". substr($sentMessage->getText(),0,60)."</td>";
     if(strlen($sentMessage->getText()) > 60){
                    echo "...";
                }
    
  
    echo "<td>{$recivedMessage->getCreationDate()}<td>";

 
}
?>
    

            </tbody>
        </table>
    </div>
</section>


</body>
</html>


<?php
$conn->close();
$conn = null;
