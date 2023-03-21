<?php
include("header.php");
require('card.php');

$_SESSION['msgFin'] = '';

function CreateCarte($nb)
{
    if ($nb != null) { //on crée les images 2 par 2 pour avoir 2 paires avec des id differents 
        for ($i = 0; $i < ($nb * 2); $i += 2) {
            $carteUp = 'image/' . $i . '.jpg';
            $carteDown = 'image/back.jpg';
            $card[$i] = new Card($i, $carteDown, $carteUp, false);
            $card[$i + 1] = new Card($i + 1, $carteDown, $carteUp, false);
        }
        return $card;
    }
}

function melangerCarte($nb, $card)
{
    if (empty($_SESSION['ordre'])) { // on crée une variable de session pour stocker toutes les carte dedans 
        $_SESSION['ordre'] = [];
        for ($i = 0; $i < ($nb * 2); $i++) {
            array_push($_SESSION['ordre'], $card[$i]);
        }
        shuffle($_SESSION['ordre']); // on melange avant de return notre variable ou y'a nos cartes
    }
    return $_SESSION['ordre'];
}

function clickedCarte($i)
{
    if (isset($_GET['id'])) { //on verifie si on a cliqué sur une carte ou pas, si oui on return true
        if ($_GET['id'] == $i->get_id_card()) {
            return true;
        }
    }
}

function comparerCarte($i)
{
    if (isset($_SESSION['carte'])) { //on crée une variable de session qui prend 2 cartes par 2
        if (count($_SESSION['carte']) < 2) { //on prend une variable de session et on verifie si elle a moins de 2 carte ( donc soit rien, soit 1 carte)
            if (clickedCarte($i)) { // on verifie si c'est des cartes sur lequels on a cliqué
                $i->set_state(true); // si oui on les met en state true
                array_push($_SESSION['carte'], $i); //et on les stock dans la variable de session carte
            }
        } else { //si notre variable de session carte est de taille 2
            if ($_SESSION['carte'][0]->img_face_up == $_SESSION['carte'][1]->img_face_up) { // on compare si les deux cartes dans notre variable sont identiques
                if (isset($_SESSION['trueCartes'])) { //on prend une variable true carte ou ya toutes les cartes TRUE
                    $_SESSION['carte'][0]->set_state(true); //et on met dedans les deux cartes vu qu'elles sont true
                    $_SESSION['carte'][1]->set_state(true);
                } else {
                    $_SESSION['trueCartes'] = []; //on le definie s'il existe pas
                }
                array_push($_SESSION['trueCartes'], $_SESSION['carte']); //et on stock les carte true dans $_SESSION['trueCartes']
                $_SESSION['carte'] = []; //et on vite le $_SESSION['carte'] pour pouvoir recommencer la boucle
            } else {
                $_SESSION['carte'][0]->set_state(false); //les deux cartes sont pas identiques alors on remet les states a false
                $_SESSION['carte'][1]->set_state(false);
                $_SESSION['carte'] = []; //on vite le $_SESSION['carte'] pour pouvoir recommencer la boucle
            }
            if (isset($_SESSION['nbCoups'])) { //un compteur de coups
                $_SESSION['nbCoups']++; //s'il existe, on l'incremente 
            } else {
                $_SESSION['nbCoups'] = 1; //s'il existe pas, on l'initialise a 1 (vu que la on a forcement fais 1 coup)
            }
        }
    } else {
        $_SESSION['carte'] = []; //on le definie s'il existe pas
    }
}
function finPartie()
{ // quand toutes les cartes sont true
    if (isset($_SESSION['trueCartes'])) {
        if (count($_SESSION['trueCartes']) == (count($_SESSION['ordre']) / 2)) { //si le nombre de cartes true est egale au nombre de carte (on divise par 2 pcq dans notre code on utilise $nb * 2)
            $_SESSION['score'] = (count($_SESSION['trueCartes']) * 3) - $_SESSION['nbCoups']; //ma façon de calculer le score
            $_SESSION['msgFin'] = "PARTIE TERMINÉE, VOTRE SCORE EST : " . $_SESSION['score']; //message de fin
        }
    }
}

function resetGame()
{ // on unset tout et on reinitialise la partie
    if (isset($_GET['reset'])) {
        session_destroy();
        unset($_GET);
        unset($_POST);
        header('location:memory.php');
    }
}

function nombreCartes()
{ // pour recuperer le nombre de carte via la methose $_POST
    if (isset($_POST['diff'])) {
        return $_POST['diff'];
    }
}

function AfficherCarte($nb) //la fonction qui fais tourner le jeu
{
?>
    <form method="GET">
        <?php
        $card = CreateCarte($nb);
        $tab = melangerCarte($nb, $card); // $tab = $_SESSION['ordre']
        foreach ($tab as $i) {
            comparerCarte($i);
            if ($i->get_state() == false) { ?>
                <button type="submit" value="<?= $i->get_id_card() ?>" name="id">
                    <img src=<?php echo $i->get_img_face_down(); ?>>
                </button>
            <?php } else {
            ?>
                <!-- <button type="submit" value="<?= $i->get_id_card() ?>" name="id"> -->
                <img src=<?php echo $i->get_img_face_up(); ?>>
                <!-- </button> -->
        <?php }
        }
        ?>
    </form>
<?php }

resetGame();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>memory</title>
</head>

<body class="body-memory">
    <div class="difficulte">
        <form method="post">
            <label class="paraf">Veuillez choisir le niveau de difficulté : </label>
            <select class="box" name="diff" id="diff">
                <option value="3">6 Cartes</option>
                <option value="6">12 Cartes</option>
                <option value="11">22 Cartes</option>
            </select>
            <input type="submit" name="Envoyer">
        </form>
    </div>
    <div class="pourflex">
        <?php if (isset($_SESSION['nbCoups'])) { ?>
            <div class="coup">Compteur de coup : </br><?= $_SESSION['nbCoups']; ?></div>
        <?php } ?>

        <div class="jeu">
            <?php
            $_SESSION['nb'] = intval(nombreCartes()); //on recupere le nb de carte du selecte, on le convertie en int
            AfficherCarte($_SESSION['nb']);
            finPartie();
            ?>
        </div>
    </div>
    <div class="msgFin"><?= $_SESSION['msgFin']; ?></div>
    <div class="reinitialiser">
        <form method="get">
            <button class="button" type="submit" name="reset">Reinitialiser la partie</button>
        </form>
    </div>

</body>