<?php

include_once('config/sqlconnect.php');

$search = $_POST['search'];
$search_mult = str_replace(" ", "%", $search);


if(isset($_POST['search']) && !empty($_POST['search'])) {

	if(array_key_exists('search', $_POST))
	{

		$stmt = $bdd -> prepare("SELECT idArticles, a.titre AS titre, subtitle, DATE_FORMAT(datePublication, '%b %d, %Y') AS datePub, contenu, statut, imgUne, users_idUsers, c.titre AS titreCategorie , statut,  users_idUsers, userName
			FROM articles a 
			INNER JOIN categories c 
			ON a.categories_idCategories = c.idCategories
			LEFT JOIN blogUsers 
			ON idUsers = users_idUsers
			WHERE a.titre LIKE :search OR subtitle LIKE :search OR contenu LIKE :search OR motsClefs LIKE :search AND statut = 1
			ORDER BY datePublication DESC, idArticles DESC");
		$stmt -> execute(array(
				':search' => '%'.$search_mult.'%'
				));

		$count = $stmt->rowCount();
		$result = $stmt->fetchAll();

	}
}

$stmt = $bdd->prepare("SELECT idArticles, statut, COUNT(idCommentaires) AS totalComm, datePublication
		FROM articles
		LEFT JOIN commentaires
		ON articles_idArticles = idArticles
		WHERE statut = 1
		GROUP BY idArticles
		ORDER BY datePublication DESC, idArticles DESC");

	$stmt->execute();

	$comments = $stmt -> fetchAll();






$pagetitle = 'Blog - Search';


include('tpl/header.phtml');
include('tpl/search.phtml');
include('tpl/footer.phtml');