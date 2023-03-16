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

    <h1>Créer un nouvel article</h1>

    <?php
    require('user.php');
    require('config.php');

    

    // function afficher($bdd){} 
    
    ?> 
    
    <form method="POST">
        <label>Nom article : </label>
        <input type="text" name="article" required></br>

        <label>Choisir des catégories : </br></label>

        <?php //afficher($bdd);
        $req = $bdd->prepare("SELECT * FROM categorie");
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($result);
        foreach ($result as $key => $value) { ?>
            <input type="checkbox" name="categorie[]" value="<?= $value["id"] ?>">
            <label><?= $value["nom"] ?></label></br>
        <?php }
        ?>

        </br><button class="button"><a href="categorie.php">Créer une nouvelle catégorie</a></button>

        </br><input type="submit" name="submit">
    </form>

    <?php
    function submit($bdd){
        if (isset($_POST["submit"])) {
            //inserer l'article dans la table article
            $request2 = $bdd->prepare('INSERT INTO `articles`(`article`, `id_utilisateur`) VALUES (?,?)');
            $request2->execute([$_POST['article'],$_SESSION['user']->get_id($bdd)]);

            $request1 = $bdd->prepare('SELECT * FROM `articles`');
            $request1->execute();
            $res = $request1->fetchAll(PDO::FETCH_ASSOC);
            $b = $res[count($res)-1]['id'];

            $req = $bdd->prepare("SELECT * FROM articles INNER JOIN utilisateurs ON articles.id_utilisateur = utilisateurs.id WHERE articles.id_utilisateur = utilisateurs.id");
            $req->execute();
            $result = $req->fetchAll(PDO::FETCH_ASSOC); 

            if (isset($_POST["categorie"])){
                for ($i=0; $i < count($_POST["categorie"]); $i++){
                    //inserer l'id de la categorie dans la table liaison
                    $request = $bdd->prepare('INSERT INTO `liaison`(`id_article`, `id_categorie`) VALUES (?,?)');
                    $request->execute([$b,$_POST["categorie"][$i]]);
                }
            }
        }
    }

    submit($bdd);
    ?>

</body>
</html>