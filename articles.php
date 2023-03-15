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

    function afficher($bdd, $ordre)
    {
        $req = $bdd->prepare("SELECT * FROM articles INNER JOIN utilisateurs ON articles.id_utilisateur = utilisateurs.id WHERE articles.id_utilisateur = utilisateurs.id ORDER BY articles.id $ordre");
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $key => $value) {
            echo 'Login : ' . $value['login'] . '.' . ' Article : ' . $value['article'] . '</br>';
        }
    }

    if (isset($_GET["ordre"])) {  // Si c'est DESC alors rendre ASC
        if ($_GET["ordre"] == "DESC") {
            $ordre = "ASC";
            afficher($bdd, $ordre);
        } else if ($_GET["ordre"] == "ASC") { // Si c'est ASC alors rendre DESC
            $ordre = "DESC";
            afficher($bdd, $ordre);
        }
    } else { // Si c'est rien (au lancement de la page) alors mettre DESC par defaut
        $ordre = "DESC";
        afficher($bdd, $ordre);
    }
    ?>
    <form method="GET">
        <input type="submit" name="ordre" value="<?= $ordre ?>">
    </form>

</body>

</html>