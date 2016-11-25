<?php
require_once '../src/User.php';
require_once 'dbConnection.php';
redirectIfNotLogged();

if (isset($_SESSION['loggedUserId'])) {
    $loggedUser = User::loadUserById($conn, $_SESSION['loggedUserId']);
} else {
    echo "Error. Please log In again.";
}


$allUsers = User::loadAllUsers($conn);
?>
<html>
    <head>
        <title>Your Profile</title>
        <meta charset="UTF-8">
        <link <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/lumen/bootstrap.min.css">
    </head>
    <body>
        <p>Logged as: <a href="user_site.php" class="btn btn-link"><?php echo $loggedUser->getUsername(); ?></a></p>

<?php
include "menu.html";
?>


        <h2 class="text-primary">User List</h2>
        <table class="table table-striped table-hover ">
            <thead>
                <tr>

                    <th>User Name</th>
                    <th>Email Address</th>
                    <th>Action</th>
            </thead>
<?php
if (!empty($allUsers)) {
    foreach ($allUsers as $user) {
        if ($user != $loggedUser) {
            ?>  
                        <tbody>
                            <tr class="active">
                                <td><?php echo "{$user->getUsername()}"; ?></td>
                                <td><?php echo "{$user->getEmail()}"; ?></td>
                                <td><?php echo "<a class='btn btn-link' href='member_profile.php?user={$user->getId()}'>Show Profile</a><br>"; ?>
                        <?php echo "<a class='btn btn-link' href='send_message.php?userId={$user->getId()}'>Send Message</td>"; ?></td>
                        <?php
                    }
                }
            }


            $conn->close();
            $conn = null;

            