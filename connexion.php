<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
<?php include("header.php"); ?>

    <h1>Connexion</h1>

    <?php
    require('user.php');

    function submit()
    {
        if (isset($_POST["submit"])) {
                $user = new User($_POST['login'], $_POST['password'], '', '', '');
                $user->connect($_POST['login'],$_POST['password']);
                $user->isConnected();
        }
    }

    ?>

    <form method="post">
        <label>Login: </label>
        <input type="text" name="login"></br>

        <label>Password: </label>
        <input type="text" name="password"></br>

        <input type="submit" name="submit">
    </form>

    <?php
    submit()
    ?>

</body>
</html>