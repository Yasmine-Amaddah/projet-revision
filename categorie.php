<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégorie</title>

</head>

<body>
<?php include("header.php"); ?>

    <h1>Créer une nouvelle catégorie</h1>

    <?php
    require('user.php');
    require('config.php');

    function submit($bdd)
    {
        if (isset($_POST["submit"])) {
            if (!empty($_POST["categorie"])) {
                $request = $bdd->prepare('INSERT INTO `categorie`(`nom`) VALUES (?)');
                $request->execute([$_POST['categorie']]);
                //$result = $request->fetchAll(PDO::FETCH_ASSOC);
            }
            else {
                echo "Veuillez écrire une catégorie";
            }
        }
    }

    ?>

    <form method="POST">
        <label>Nouvelle catégorie : </label>
        <input type="text" name="categorie"></br>

        <input type="submit" name="submit">

        <button class="button"><a href="article.php">Retour au formulaire article</a></button>
    </form>

    <?php
    submit($bdd);
    ?>

</body>

</html>