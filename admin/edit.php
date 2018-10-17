<?php
session_start();
require '../config/sqlconnect.php';

/* Si on est pas connecté on redirige vers la page login.php*/
if(!isset($_SESSION['connected']) || $_SESSION['connected'] == false)
header('Location:login.php');

/* EDITER */

if(array_key_exists('idArticles', $_GET))
{
	/*GET ARTICLE TO EDIT*/

	$idArticle = $_GET['idArticles'];
	//SELECTIONNER DONNÉES USER ET INJECTER DANS LE FORMULAIRE
	$stmt = $bdd->prepare('SELECT idArticles, a.titre AS titre, subtitle, datePublication, dateEdition, contenu, motsClefs, statut, imgUne, resume, categories_idCategories, idCategories, c.titre AS titreCategorie
	FROM articles a 
	INNER JOIN categories c 
	ON a.categories_idCategories = c.idCategories 
	WHERE idArticles = ?');
	
	$stmt->execute(array($idArticle));

	$article = $stmt -> fetch(PDO::FETCH_ASSOC);


	/*GET CATEGORIES*/

	$stmt = $bdd->prepare("SELECT idCategories, titre
		FROM categories
		ORDER BY idCategories ASC");

	$stmt->execute();

	$category = $stmt -> fetchAll();

}

if (array_key_exists('cancel', $_POST)) {
	header('location:https://blog.ynkrabo.fr/admin/admin.php');
}

if(array_key_exists('submit', $_POST)) {

	//var_dump($_FILES);exit();

	if(isset($_FILES['imgUne'])){
		$errors= array();
		$file_name = $_FILES['imgUne']['name'];
		$file_size = $_FILES['imgUne']['size'];
		$file_tmp = $_FILES['imgUne']['tmp_name'];
		$file_type = $_FILES['imgUne']['type'];
		$file_ext=strtolower(end(explode('.',$_FILES['imgUne']['name'])));

		$expensions= array("jpeg","jpg","png");

		if(in_array($file_ext,$expensions)=== false){
			$errors[]="extension not allowed, please choose a JPEG or PNG file.";
		}

		if($file_size >= 5120000) {
			$errors[]='File size must be under 5 MB';
		}

		if(empty($errors)==true) {
			move_uploaded_file($file_tmp,"uploads/".$file_name);
			echo "Success";
		}else{
			print_r($errors);
		}
	}

	$edit = $bdd->prepare('UPDATE articles 
		SET titre=:titre, subtitle=:subtitle, datePublication=:publication, dateEdition=:edition, contenu=:contenu, motsClefs=:clefs, statut=:statut, imgUne=:imgUne, resume=:resume, categories_idCategories=:categories
		WHERE idArticles = :idArticles');
	$edit -> execute(
		array( 
		'titre' => $_POST['titre'],
		'subtitle' => $_POST['subtitle'],
		'publication' => $_POST['publication'],
		'edition' => date('Y-m-d'),
		'contenu' => $_POST['contenu'],
		'clefs' => $_POST['clefs'],
		'statut' => array_key_exists('statut', $_POST)?1:0,
		'imgUne' => ($_FILES['imgUne']['tmp_name'] != '') ? $file_name : $_POST['images'],
		'resume' => $_POST['resume'],
		'categories' => $_POST['categorie'],
		'idArticles' => $_POST['idArticles']
		));
	header('location:admin.php');
}
	
include 'tpl/edit.phtml';

?>