<?php

require_once '../src/User.php';
require_once 'dbConnection.php';
if (isset($_SESSION['loggedUserId'])) {
    $loggedUser = User::loadUserById($conn,$_SESSION['loggedUserId']); 
    $loggedUser->delete($conn);
    unset($_SESSION['loggedUserId']);
    echo "Your account has been already deleted";
    
}else {
   echo "Error. Please log In again.";
}

  
 


