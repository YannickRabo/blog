<?php 

include('config/sqlconnect.php');

$erreur = '';


/*REQUEST FOR ARTICLES 3-... AND CATEGORY*/
	//var_dump($_SERVER);
if(array_key_exists('idArticles', $_GET))
{
	$idArticle = $_GET['idArticles'];
	//SELECTIONNER DONNÉES USER ET INJECTER DANS LE FORMULAIRE



	$stmt = $bdd->prepare("SELECT idArticles, a.titre AS titre, subtitle, DATE_FORMAT(datePublication, '%b %d, %Y') AS datePublication, contenu, motsClefs, statut, imgUne, resume, users_idUsers, categories_idCategories, idCategories, c.titre AS titreCategorie
		FROM articles a 
		INNER JOIN categories c 
		ON a.categories_idCategories = c.idCategories
		WHERE idArticles = ?");

	$stmt->execute(array($idArticle));

	$article = $stmt -> fetch(PDO::FETCH_ASSOC);


	$comments = $_GET['idArticles'];
	//SELECTIONNER DONNÉES USER ET INJECTER DANS LE FORMULAIRE
	$stmt = $bdd->prepare("SELECT pseudo, texte, idArticles, articles_idArticles, DATE_FORMAT(comm_date, '%b %d, %Y at %H:%i') AS comm_date
		FROM commentaires
		INNER JOIN articles ON idArticles = articles_idArticles
		WHERE idArticles = ?
		ORDER BY comm_date DESC");

	$stmt->execute(array($comments));

	$comments = $stmt -> fetchAll(PDO::FETCH_ASSOC);

}

/*REQUEST FOR POSTER*/

$stmt = $bdd->prepare("SELECT idArticles, users_idUsers, userName
	FROM articles
	LEFT JOIN blogUsers ON idUsers = users_idUsers
	GROUP BY idArticles
	ORDER BY datePublication DESC");

$stmt->execute();

$users = $stmt -> fetch(PDO::FETCH_ASSOC);


$pagetitle = 'Blog - Article';

include('tpl/header.phtml');
include 'tpl/article.phtml';
include('tpl/footer.phtml');
