<?php
require('user.php'); 
require('config.php');

$user = new User('', '', '', '', '');
$user->disconnect();
header("Location:connexion.php");
?>