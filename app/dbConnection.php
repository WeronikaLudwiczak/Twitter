<?php

function connectToDatabase() {
$host = "localhost";
$user = "root";
$password = "root";
$dbName = "twitter_db";
     
    $conn = new mysqli($host, $user, $password, $dbName);
    if ($conn->connect_error == False) {
     // return $conn;
      echo "Jestes polaczony";
    }else {
         die('Unable to connect to database: ' . $conn->connect_error);
    
}

    }


 connectToDatabase();