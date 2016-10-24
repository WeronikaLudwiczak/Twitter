<?php

//require_once '../src/User.php';
require_once 'dbConnection.php';


unset($_SESSION['loggedUserId']);
header("Location:index.php");

