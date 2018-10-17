<?php 

include_once('config/sqlconnect.php');

$erreur = '';

try
{

	if(array_key_exists('idCategories', $_GET))
	{
		
		$idCat = $_GET['idCategories'];
		//SELECTIONNER DONNÉES ET INJECTER DANS LE FORMULAIRE

		$stmt = $bdd->prepare("SELECT idArticles, a.titre AS titre, subtitle, DATE_FORMAT(datePublication, '%b %d, %Y') AS datePub, contenu, motsClefs, statut, imgUne, resume, users_idUsers, categories_idCategories, idCategories, c.titre AS titreCategorie, users_idUsers, userName
			FROM articles a 
			INNER JOIN categories c 
			ON a.categories_idCategories = c.idCategories
			LEFT JOIN blogUsers 
			ON idUsers = users_idUsers
			WHERE datePublication <= NOW() AND statut = 1 AND idCategories = ?
			ORDER BY datePublication DESC, idArticles DESC");

		$stmt->execute(array($idCat));

		$result = $stmt->fetchAll();



		/*REQUEST FOR NUMBER OF COMMENTS*/

		$stmt = $bdd->prepare("SELECT idArticles, statut, COUNT(idCommentaires) AS totalComm, idCategories, datePublication
			FROM articles
            INNER JOIN categories c 
			ON categories_idCategories = idCategories
			LEFT JOIN commentaires
			ON articles_idArticles = idArticles
			WHERE statut = 1  AND idCategories = ?
			GROUP BY idArticles
			ORDER BY datePublication DESC, idArticles DESC");

		$stmt->execute(array($idCat));

		$comments = $stmt -> fetchAll();

	}

}
catch(Exception $e)
{

	$erreur = 'Erreur  : '.$e->getMessage();
}



$pagetitle = 'Blog - Category';

include('tpl/header.phtml');
include 'tpl/category.phtml';
include('tpl/footer.phtml');
