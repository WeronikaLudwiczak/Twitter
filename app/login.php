
<?php
require_once '../src/User.php';
require_once 'dbConnection.php';


if($_SERVER['REQUEST_METHOD']=='POST'){
  $loggedUser=  User::LogIn($conn, $_POST['email'], $_POST['password']);
  
  if(!empty($loggedUser)){
      $_SESSION['loggedUserId'] = $loggedUser->getId();
      header("Location:index.php");
      
  }else{
      echo ('<div class="alert alert-dismissible alert-danger">Check your Password!</div>');
  }
}


?>


<html>
<head>
    <title>LogIn</title>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
<div class="well">
    <h3 class="text-primary"><center>Welcome in your Tweeter World! Please Log In.</center></h3>
</div>
     <div class="form-group">

    <form  method="POST" method ="post" class="form-horizontal">
  <fieldset>
      <legend><strong>Form</strong></legend>
    
    <label  class="col-lg-2 control-label" for="mail">Email</label>
      <div class="col-lg-10">
        <input class="form-control" type="email" name="email" placeholder="Email address"><br>
      </div>

     <label class="col-lg-2 control-label" for="password">Passowrd</label>
      <div class="col-lg-10">
          <input class="form-control" type="password" name="password" placeholder="Password"><br>
      </div>  
            <button type="submit" name="login" class="btn">Log In</button>
        </p>
        <p>
            <a href="registration_site.php">No account? Regiester now!</a>
        </p>
    </form>
</div>
</div>
</body>
</html>

<?php
$conn->close();
$conn = null;