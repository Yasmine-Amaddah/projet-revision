<?php
include("../header.php");
require('card.php');

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

function melangerCarte($nb,$card)
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

function retournerCarteTrue($i)
{
    if ($_SESSION['trueCartes'] != null) {
        if (comparerCarte($i)) {
            $_SESSION['carte'][0]->set_state(true);
            $_SESSION['carte'][1]->set_state(true);
            array_push($_SESSION['trueCartes'], $_SESSION['carte']);
            header("Location:memory.php");
        }
    } else {
        $_SESSION['trueCartes'] = [];
    }
}

function comparerCarte($i)
{ //var_dump($_SESSION['carte']);
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
                //return true;
            } else {
                $_SESSION['carte'][0]->set_state(false);
                $_SESSION['carte'][1]->set_state(false);
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
?>
    <form method="GET">
        <?php
        $card = CreateCarte($nb);
        $tab = melangerCarte($nb,$card); // $tab = $_SESSION['ordre']
        foreach ($tab as $i) {
            comparerCarte($i);
            if ($i->get_state() == false) { ?>
                <button type="submit" value="<?= $i->get_id_card() ?>" name="id">
                    <img src=<?php echo $i->get_img_face_down(); ?>>
                </button>
            <?php } else {
            ?>
                <button type="submit" value="<?= $i->get_id_card() ?>" name="id">
                    <img src=<?php echo $i->get_img_face_up(); ?>>
                </button>
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