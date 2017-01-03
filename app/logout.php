<?php


require_once 'dbConnection.php';


unset($_SESSION['loggedUserId']);
header("Location:index.php");

