<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once "../scripts/config.php";

     
$conn = new mysqli($host, $user, $password, $dbName);

    if ($conn->connect_error == False) {
     return $conn;
    
    }else {
         die('Unable to connect to database: ' . $conn->connect_error);
    
    }

    



function redirectIfNotLogged(){
    if(isset($_SESSION["loggedUserId"]) === false){
        header("Location:login.php");
    }
}
function redirectIfLoggedIn(){
    if(isset($_SESSION["loggedUserId"]) === true){
        header("Location:index.php");
    }
}