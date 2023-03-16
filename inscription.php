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

    <h1>Inscription</h1>

    <?php
    require('user.php');
    require('config.php');

    function submit($bdd)
    {
        if (isset($_POST["submit"])) {
            if (isCompatible($bdd)) {
                $user = new User($_POST['login'], $_POST['password'], $_POST['email'], $_POST['firstname'], $_POST['lastname']);
                $user->register($bdd);
                }
                else {
                    echo "Ce login existe deja, utilisez un autre login !";
                }
            
            }
        }
    

    function isCompatible()
    {
        if ($_POST['password'] == $_POST['password2']) {
            return true;
        } else {
            echo "Les deux mots de passe ne sont pas identiques";
        }
    }

    ?>

    <form method="post">
        <label>Login: </label>
        <input type="text" name="login"></br>

        <label>Password: </label>
        <input type="text" name="password"></br>

        <label>Confirmer le Password: </label>
        <input type="text" name="password2"></br>

        <label>Email: </label>
        <input type="text" name="email"></br>

        <label>First name: </label>
        <input type="text" name="firstname"></br>

        <label>Last name: </label>
        <input type="text" name="lastname"></br>

        <input type="submit" name="submit">

    </form>

    <?php
    submit($bdd);
    ?>

</body>

</html>