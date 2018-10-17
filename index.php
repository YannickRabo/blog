<?php

include_once('config/sqlconnect.php');


/*REQUEST FOR RECENT ARTICLES 1-3 AND CATEGORY*/

$stmt = $bdd->prepare("SELECT idArticles, a.titre AS titre, subtitle, DATE_FORMAT(datePublication, '%b %d, %Y') AS datePub, contenu, statut, imgUne, users_idUsers, c.titre AS titreCategorie, users_idUsers, userName
	FROM articles a 
	INNER JOIN categories c 
	ON a.categories_idCategories = c.idCategories	
	LEFT JOIN blogUsers ON idUsers = users_idUsers 
	WHERE datePublication <= NOW() AND statut = 1 
	ORDER BY datePublication DESC, idArticles DESC
	LIMIT 4");

$stmt->execute();

$recent = $stmt -> fetchAll();

/*REQUEST FOR ARTICLES 3-... AND CATEGORY*/

$stmt = $bdd->prepare("SELECT idArticles, a.titre AS titre, subtitle, DATE_FORMAT(datePublication, '%b %d, %Y') AS datePub, contenu, motsClefs, statut, imgUne, resume, users_idUsers, categories_idCategories, idCategories, c.titre AS titreCategorie, users_idUsers, userName 
	FROM articles a 
	INNER JOIN categories c ON a.categories_idCategories = c.idCategories 
	LEFT JOIN blogUsers ON idUsers = users_idUsers 
	WHERE datePublication <= NOW() AND statut = 1 
	ORDER BY datePublication DESC, idArticles DESC 
	LIMIT 4, 9999999999999 ");

$stmt->execute();

$result = $stmt -> fetchAll();


/*REQUEST FOR NUMBER OF COMMENTS*/

$stmt = $bdd->prepare("SELECT idArticles, statut, COUNT(idCommentaires) AS totalComm
	FROM articles
	LEFT JOIN commentaires
	ON articles_idArticles = idArticles
	WHERE statut = 1
	GROUP BY idArticles
	ORDER BY datePublication DESC, idArticles DESC
	LIMIT 4, 9999999999999");

$stmt->execute();

$comments = $stmt -> fetchAll(PDO::FETCH_ASSOC);


$pagetitle = 'Blog - Yannick Rabo';

include('tpl/header.phtml');
include('tpl/blog.phtml');
include('tpl/footer.phtml');


