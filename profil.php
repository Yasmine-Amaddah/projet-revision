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

    <h1>Article</h1>

    <?php
    require('user.php');
    require('config.php');

    function submit($bdd)
    {
        if (isset($_POST["submit"])) {
            $user = new User($_POST['login'], $_POST['password'], $_POST['email'], $_POST['firstname'], $_POST['lastname']);
            $user->update($_POST["login"], $_POST["password"], $_POST["email"], $_POST["firstname"], $_POST["lastname"]);
        
        // modifier les sessions avec la nouvelle valeur de $_POST comme ça les champs sont pre rempli avec les nouvelles valeurs
            $_SESSION['user']['login'] = $_POST['login'];
            $_SESSION['user']['password'] = $_POST["password"];
            $_SESSION['user']['email'] = $_POST["email"];
            $_SESSION['user']['first name'] = $_POST["firstname"];
            $_SESSION['user']['last name'] = $_POST["lastname"];
            header("refresh:0");
        }
        
    }

    ?>

    <form method="post">
        <label>Login: </label>
        <input type="text" name="login" value="<?= $_SESSION['user']['login'] ?>"></br>

        <label>Password: </label>
        <input type="text" name="password" value="<?= $_SESSION['user']['password'] ?>"></br>

        <label>Email: </label>
        <input type="text" name="email" value="<?= $_SESSION['user']['email'] ?>"></br>

        <label>First name: </label>
        <input type="text" name="firstname" value="<?= $_SESSION['user']['first name'] ?>"></br>

        <label>Last name: </label>
        <input type="text" name="lastname" value="<?= $_SESSION['user']['last name'] ?>"></br>

        <input type="submit" name="submit">

    </form>

    <?php
    submit($bdd);
    ?>

</body>

</html>