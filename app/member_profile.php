<?php
require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once 'dbConnection.php';

redirectIfNotLogged();
if ($_SERVER['REQUEST_METHOD'] === 'GET' and isset($_GET['user'])) {
    $memberId = $_GET['user'];
    $member=  User::loadUserById($conn, $memberId);
    
}
?>
<div>
    <p>Informacje:</p>
    <p><?php echo $member->getUsername();?></p>

</div>
<div>

