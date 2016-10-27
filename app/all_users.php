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


?>
<html>
<head>
    <title>Your Profile</title>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <p>Logged as: <a href="user_site.php" class="btn btn-link"><?php echo $loggedUser->getUsername();?></a></p>
    
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <a class="navbar-brand" href="index.php">Home Page</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
          <li ><a href="user_edit.php">Edit Your Profile</a></li>
        <li><a href="#">Send Message</a></li>
        <li><a href="#">Users</a></li>
      </ul>
 
      <ul class="nav navbar-nav navbar-right">
          <li><a href='logout.php'>Log Out</a></li>
      </ul>
    </div>
  </div>
</nav>
    

     <h2 class="text-primary">User List</h2>
    <table class="table table-striped table-hover ">
  <thead>
    <tr>
     
      <th>User Name</th>
      <th>Email Address</th>
      <th>Action</th>
  </thead>
  <?php
  
  if(!empty($allUsers)){
    foreach ($allUsers as $user){
        if ($user != $loggedUser){
              ?>  
  <tbody>
    <tr class="active">
        <td><?php   echo "{$user->getUsername()}";?></td>
        <td><?php   echo "{$user->getEmail()}";?></td>
        <td><?php   echo "<a class='btn btn-link' href='member_profile.php?user={$user->getId()}'>Show Profile</a><br>";?></td>
        <?php
        }
    }
}
   
