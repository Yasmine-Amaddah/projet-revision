<?php
include("../header.php");
require('card.php');


function CreateCarte($nb)
{ 
    for ($i = 0; $i < ($nb * 2) ; $i++) {
        $carteUp = 'image/' . $i . '.jpg';
        $carteDown = 'image/back.jpg';
        $card[$i] = new Card($i, $carteDown, $carteUp, false);
        $card[$i+1] = new Card($i+1, $carteDown, $carteUp, false);
        $i++;
    }
    return $card;
}

function clickedCarte($a, $j)
{  
    if (isset($_GET['id'])) {
        if ($_GET['id'] == $a[$j]->id_card) {
            $a[$j]->state = true;
        }
    }

}

function AfficherCarte($nb)
{
    $a = CreateCarte($nb);
    for ($i = 0; $i < count($a); $i++) {
        clickedCarte($a, $i);
        if ($a[$i]->state == false) { ?>
            <form method="GET">
                <button type="submit" value="<?= $i ?>" name="id">
                    <img src=<?php echo $a[$i]->get_img_face_down(); ?>>
                </button>
            </form>
        <?php } else {
        ?>
            <form method="GET">
                <button type="submit" value="<?= $i ?>" name="id">
                    <img src=<?php echo $a[$i]->get_img_face_up(); ?>>
                </button>
            </form>
<?php }
    }
}


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

</body>