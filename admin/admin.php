<?php
session_start();

include('../config/sqlconnect.php');

/* Si on est pas connecté on redirige vers la page login.php*/
if(!isset($_SESSION['connected']) || $_SESSION['connected'] == false)
header('Location:login.php');


$stmt = $bdd->prepare("SELECT idArticles, a.titre AS titreArticle, subtitle, DATE_FORMAT(datePublication, '%d/%m/%Y') AS datePublication, DATE_FORMAT(dateEdition, '%d/%m/%Y')dateEdition, contenu, motsClefs, statut, imgUne, resume, idArticles, categories_idCategories, idCategories, c.titre AS titreCategorie
	FROM articles a 
	INNER JOIN categories c 
	ON a.categories_idCategories = c.idCategories
	ORDER BY idArticles DESC");

$stmt->execute();

$results = $stmt->fetchAll();

include 'tpl/admin.phtml';
