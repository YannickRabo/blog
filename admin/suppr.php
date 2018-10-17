<?php

require '../config/sqlconnect.php';

/* SUPPRIMER */

if(array_key_exists('delArticle', $_GET)) {
	$delete = $bdd->prepare('DELETE FROM articles WHERE idArticles = ?');
	$delete -> execute(array($_GET['delArticle']));
}



/* AJOUTER */

?>