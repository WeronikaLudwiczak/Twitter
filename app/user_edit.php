<?php
require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once 'dbConnection.php';
redirectIfNotLogged();


if (isset($_SESSION['loggedUserId'])) {
    $loggedUser = User::loadUserById($conn, $_SESSION['loggedUserId']);
} else {
    echo "Error. Please log In again.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['username']) && strlen($_POST['username']) > 0) {
        $loggedUser->setUsername($_POST['username']);
        $loggedUser->saveToDB($conn);
        echo 'You have new User Name<br>';
    } else {
        echo 'Your new User Name is too short!<br>';
    }
    if (isset($_POST['email']) && filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL)) {
        $loggedUser->setEmail($_POST['email']);
        $loggedUser->saveToDB($conn);
        echo '<p class="text-primary"> You have new email adress</p><br>';
    } else {
        echo '<p class="text-danger">Your new Email address is wrong!</p><br>';
    }

    $oldPass = $loggedUser->verifyPassword($_POST['old_password']);
    if ($oldPass && isset($_POST['password1']) && strlen($_POST['password1']) > 0 && isset($_POST['password2']) && strlen($_POST['password2']) > 0) {
        $loggedUser->setPassword($_POST['password1'], $_POST['password2']);
        $loggedUser->saveToDB($conn);
    } else {
        echo "Error! Password is incorrect!";
    }
}
?>

<html>
    <head>
        <title>Edit Your Profile</title>
        <meta charset="UTF-8">
        <link href="../css/style.css" rel="stylesheet">
    </head>
    <body>
        <p>Logged as: <a href="#" class="btn btn-link"><?php echo $loggedUser->getUsername(); ?></a></p>

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Twitter</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li ><a href='user_site.php'>Your Profile</a></li>
                        <li><a href="all_users.php">Users</a></li>
                        <li><a href="#">Comments</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href='logout.php'>Log Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <form  method="POST" method ="post" class="form-horizontal">
            <fieldset>
                <legend><strong>Update your Profile</strong></legend>

                <label class="col-lg-2 control-label" for="username">User Name</label>
                <div class="col-lg-10">
                    <input class="form-control" type="text" name="username" placeholder="User Name" value ="<?php echo $loggedUser->getUsername() ?>"><br>
                </div>
                <label  class="col-lg-2 control-label" for="mail">Email</label>
                <div class="col-lg-10">
                    <input class="form-control" type="email" name="email" placeholder="Email address" value ="<?php echo $loggedUser->getEmail() ?>"><br>
                </div>
                <p><center>Change your Password</center></p>

                <label class="col-lg-2 control-label" for="password">Old Passowrd</label>
                <div class="col-lg-10">
                    <input class="form-control" type="password" name="old_password" placeholder="Old Password"><br>
                </div>  

                <label class="col-lg-2 control-label" for="password">New Passowrd</label>
                <div class="col-lg-10">
                    <input class="form-control" type="password" name="password1" placeholder="New Password"><br>
                </div>  

                <label class="col-lg-2 control-label" for="password">Confirmed your new Passowrd</label>
                <div class="col-lg-10">
                    <input class="form-control" type="password" name="password2" placeholder="New Password"><br>
                </div>
                <button type="submit" name="update" class="btn">Update</button>
                </p>

        </form>
    </div>
</div>
<?php

echo "<a href='delete_User.php?user={$loggedUser->getId()}' class='btn btn-link'>Delete your Account</a>";
?>
</body>
</html>

<?php
$conn->close();
$conn = null;
