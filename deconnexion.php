<?php
require('user.php'); 

$user = new User('', '', '', '', '');
$user->disconnect();
header("Location:connexion.php");
?>