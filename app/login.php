<?php



?>


<html>
<head>
    <title>LogIn</title>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
<div class="title">
    <h1>Welcome in Tweeter World! Please Log In</h1>
</div>
<div class="log">
    <form method="post">
        <p>
        <label for="mail">e-mail</label>
            <input type="email" name="email" placeholder="email address">
        </p>
        <p>
        <label for="password">password</label>
            <input type="password" name="password" placeholder="password">
        </p>
        <p>
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

