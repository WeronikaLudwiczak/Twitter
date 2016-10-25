<?php

require_once '../src/User.php';
require_once 'dbConnection.php';
redirectIfNotLogged();

if (isset($_SESSION['loggedUserId'])) {
    $loggedUser = User::loadUserById($conn,$_SESSION['loggedUserId']);  

    
}else {
   echo "Error. Please log In again.";
  
}



$allUsers = User::loadAllUsers($conn);

if(count($allUsers) > 0){
    foreach ($allUsers as $user){
        if ($user != $loggedUser){
            echo "{$user->getUsername()}";
            echo "{$user->getEmail()}";
            echo "<a href='member_profile.php?idToShow={$user->getId()}'>Show Profile</a><br>";
        }
    }
}
