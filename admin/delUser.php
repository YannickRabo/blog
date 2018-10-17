<?php
session_start();
require '../config/sqlconnect.php';

/* SUPPRIMER */

if(array_key_exists('delUser', $_GET)) {
	$delete = $bdd->prepare('DELETE FROM blogUsers WHERE idUsers = ?');
	$delete -> execute(array($_GET['delUser']));
}
header('location:users.php');



/* AJOUTER */

?>