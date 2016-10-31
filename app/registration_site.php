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
           echo ('<div class="alert alert-dismissible alert-danger">Check your password! Registration Failed</div>');
           echo ('<br>');
       }
      
       
   } else {
       echo "Wrong email Address";
   }
     if(!empty($registerSucess)){
        $_SESSION['loggedUserId'] = $newUser->getId();
        header("Location:index.php");
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
    <div class="well">
        <h3 class="text-primary">Hello! Create your account :)</h3><br>
    </div>
    <div class="form-group">

    <form  method ="post" class="form-horizontal">
  <fieldset>
      <legend><strong>Form</strong></legend>
    
    <label  class="col-lg-2 control-label" for="mail">Email</label>
      <div class="col-lg-10">
        <input class="form-control" type="email" name="email" placeholder="Email address"><br>
      </div>
    
        
    <label class="col-lg-2 control-label" for="username">User Name</label>
      <div class="col-lg-10">
          <input class="form-control" type="text" name="username" placeholder="User Name"><br>
      </div>
    
    <label class="col-lg-2 control-label" for="password">Password</label>
      <div class="col-lg-10">
          <input class="form-control" type="password" name="password1" placeholder="Password"><br>
      </div>  
        
    <label class="col-lg-2 control-label" for="password">Confirmed your Password</label>
      <div class="col-lg-10">
          <input class="form-control" type="password" name="password2" placeholder="Password"><br>
      </div>

    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="submit" class="btn" name="register">Create your account</button>
       <p> <a href="login.php">I have account.</a></p>
      </div>
    </div>
 
    
    </div>
  </fieldset>
</form>
        

</div>
</body>
</html>

<?php
$conn->close();
$conn = null;

