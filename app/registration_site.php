<?php

require_once '../src/User.php';
require_once 'dbConnection.php';


if($_SERVER['REQUEST_METHOD'] == 'POST'){
   if(filter_var(($_POST['email']),FILTER_VALIDATE_EMAIL)) {
       $newUser = new User;
       $newUser->setEmail($_POST['email']);
       $newUser->setUsername($_POST['username']);
       $correctPassword=$newUser->setPassword($_POST['password1'], $_POST['password2']);
       
       if($correctPassword){
     $registerSucess= $newUser->saveToDB($conn);
       }else{
           echo ("Check your password!");
           echo ('<br>');
       }
      
       
   } else {
       echo "Wrong email Address";
   }
     if(!empty($registerSucess)){
        $_SESSION['loggedUserId'] = $newUser->getId();
        header("Location:index.php");
    }else{
        echo "Registration failed";
    }
}




?>

<html>
<head>
    <title>Registration</title>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="title">
        <h1>Hello! Create your account :)</h1>
    </div>
    <div class="log">
<form method="post">
    <p>
        <label for="mail">Email</label>
        <input type="email" name="email" placeholder="Email address">
    </p>
        <p>
        <label for="username">User Name</label>
        <input type="text" name="username" placeholder="User Name">
    </p>
    <p>
        <label for="password">Passowrd</label>
        <input type="password" name="password1" placeholder="Password">
    </p>
        <p>
        <label for="password">Confirmed your Passowrd</label>
        <input type="password" name="password2" placeholder="Password">
    </p>

    <p>
        <button type="submit" class="btn" name="register">Create your account</button>
    </p>
    <p><a href="login.php">I have account. Log In</a></p>
    </div>
</form>

</div>
</body>
</html>

<?php
$conn->close();
$conn = null;

