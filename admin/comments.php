<?php 
session_start();
$erreur = '';

include('../config/sqlconnect.php');

if(array_key_exists('idArticles', $_GET))
{
	//delcomment

	if(array_key_exists('delComm', $_GET)) {
		$delete = $bdd->prepare('DELETE FROM commentaires WHERE idCommentaires = ?');
		$delete -> execute(array($_GET['delComm']));
		//header('location:comments.php');
	}

	//SELECTIONNER DONNÉES USER ET INJECTER DANS LE FORMULAIRE
	$stmt = $bdd->prepare('SELECT *
		FROM commentaires
		WHERE articles_idArticles = ?');

	$stmt->execute(array($_GET['idArticles']));

	$comments = $stmt -> fetchAll(PDO::FETCH_ASSOC);

}

include('tpl/comments.phtml');
