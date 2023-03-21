<?php
include("header.php");
require('card.php');

$_SESSION['msgFin'] = '';

function CreateCarte($nb)
{
    if ($nb != null) {
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
    if (empty($_SESSION['ordre'])) {
        $_SESSION['ordre'] = [];
        for ($i = 0; $i < ($nb * 2); $i++) {
            array_push($_SESSION['ordre'], $card[$i]);
        }
        shuffle($_SESSION['ordre']);
    }
    return $_SESSION['ordre'];
}

function clickedCarte($i)
{
    if (isset($_GET['id'])) {
        if ($_GET['id'] == $i->get_id_card()) {
            return true;
        }
    }
}

function comparerCarte($i)
{
    if (isset($_SESSION['carte'])) {
        if (count($_SESSION['carte']) < 2) {
            if (clickedCarte($i)) {
                $i->set_state(true);
                array_push($_SESSION['carte'], $i);
            }
        } else {
            if ($_SESSION['carte'][0]->img_face_up == $_SESSION['carte'][1]->img_face_up) {
                if (isset($_SESSION['trueCartes'])) {
                    $_SESSION['carte'][0]->set_state(true);
                    $_SESSION['carte'][1]->set_state(true);
                } else {
                    $_SESSION['trueCartes'] = [];
                }
                array_push($_SESSION['trueCartes'], $_SESSION['carte']);
                $_SESSION['carte'] = [];
            } else {
                $_SESSION['carte'][0]->set_state(false);
                $_SESSION['carte'][1]->set_state(false);
                $_SESSION['carte'] = [];
            }
            if (isset($_SESSION['nbCoups'])) { 
                $_SESSION['nbCoups']++;
            } else {
                $_SESSION['nbCoups'] = 1;
            }
        }
    } else {
        $_SESSION['carte'] = [];
    }
}
function finPartie()
{ // quand toutes les cartes sont true
    if (isset($_SESSION['trueCartes'])) {
        if (count($_SESSION['trueCartes']) == (count($_SESSION['ordre']) / 2)) {
            $_SESSION['score'] = (count($_SESSION['trueCartes']) * 3) - $_SESSION['nbCoups'];
            $_SESSION['msgFin'] = "PARTIE TERMINÉE, VOTRE SCORE EST : " . $_SESSION['score'];
        }
    }
}

function resetGame()
{
    if (isset($_GET['reset'])) {
        session_destroy();
        unset($_GET);
        unset($_POST);
        header('location:memory.php');
    }
}

function AfficherCarte($nb)
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

function nombreCartes()
{
    if (isset($_POST['diff'])) {
        return $_POST['diff'];
    }
}

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
        $_SESSION['nb'] = intval(nombreCartes());
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