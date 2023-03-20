<?php
include("../header.php");
require('card.php');

var_dump($_SESSION['discover']);

function CreateCarte($nb)
{
    for ($i = 0; $i < ($nb * 2); $i += 2) {
        $carteUp = 'image/' . $i . '.jpg';
        $carteDown = 'image/back.jpg';
        $card[$i] = new Card($i, $carteDown, $carteUp, false);
        $card[$i + 1] = new Card($i + 1, $carteDown, $carteUp, false);
    }
    return $card;
}

function melangerCarte($nb)
{
    if (empty($_SESSION['ordre'])) {
        $_SESSION['ordre'] = [];
        for ($i = 0; $i < ($nb * 2); $i++) {
            array_push($_SESSION['ordre'], $i);
        }
        shuffle($_SESSION['ordre']);
    }
    return $_SESSION['ordre'];
}

function clickedCarte($card, $i)
{
    if (isset($_GET['id'])) {
        if ($_GET['id'] == $card[$i]->id_card) {
            $card[$i]->state = true;
        }
    }
}

function retournerCarteTrue($card, $i)
{
    if ($_SESSION['trueCartes'] != null) {
        if (comparerCarte($card, $i)) {
            $_SESSION['carte'][0]->set_state(true);
            $_SESSION['carte'][1]->set_state(true);
            array_push($_SESSION['trueCartes'],$_SESSION['carte']);
            var_dump("ok");
        } 
    }
    else {
        $_SESSION['trueCartes'] = [];
    }
}

function comparerCarte($card, $i)
{

    if (isset($_SESSION['carte'])) {
        if (count($_SESSION['carte']) < 2) {
            if ($card[$i]->state == true) {
                array_push($_SESSION['carte'], $card[$i]);
                var_dump($_SESSION['carte']);
            }
        } else {
            if ($_SESSION['carte'][0]->img_face_up == $_SESSION['carte'][1]->img_face_up) {
                $_SESSION['carte'] = [];
                return true;
            } else {
                $_SESSION['carte'] = [];
                return false;
            }
        }
    } else {
        $_SESSION['carte'] = [];
    }
}


function resetGame()
{
    if (isset($_GET['reset'])) {
        session_destroy();
        unset($_GET);
        header('location:memory.php');
    }
}


function AfficherCarte($nb)
{
    $card = CreateCarte($nb);
    $tab = melangerCarte($nb);
    foreach ($tab as $i) {
        //for ($i = 0; $i < count($a); $i++) {
        clickedCarte($card, $i);
        comparerCarte($card, $i);
        //retournerCarteTrue($card, $i);
        if ($card[$i]->state == false) { ?>
            <form method="GET">
                <button type="submit" value="<?= $i ?>" name="id">
                    <img src=<?php echo $card[$i]->get_img_face_down(); ?>>
                </button>
            </form>
        <?php } else {
        ?>
            <form method="GET">
                <button type="submit" value="<?= $i ?>" name="id">
                    <img src=<?php echo $card[$i]->get_img_face_up(); ?>>
                </button>
            </form>
<?php }
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

<body>
    <div style="display: flex; flex-wrap: wrap">
        <?php
        AfficherCarte(6);
        ?>
    </div>
    <div style="margin: 5%;">
        <form method="get">
            <button class="button" type="submit" name="reset">Reinitialiser la partie</button>
        </form>
    </div>

</body>