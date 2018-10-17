<?php
session_start();
require '../config/sqlconnect.php';

/* SUPPRIMER */

if(array_key_exists('delArticle', $_GET)) {
	$delete = $bdd->prepare('DELETE FROM commentaires WHERE articles_idArticles = ?');
	$delete -> execute(array($_GET['delArticle']));
	$delete = $bdd->prepare('DELETE FROM articles WHERE idArticles = ?');
	$delete -> execute(array($_GET['delArticle']));
}
header('location:admin.php');





?>