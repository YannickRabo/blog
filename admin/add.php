<?php
session_start();
$erreur = '';

/* Si on est pas connecté on redirige vers la page login.php*/
if(!isset($_SESSION['connected']) || $_SESSION['connected'] == false)
header('Location:login');

try
{

	require '../config/sqlconnect.php';


	$stmt = $bdd->prepare("SELECT idCategories, titre
		FROM categories
		ORDER BY idCategories ASC");

	$stmt->execute();

	$category = $stmt -> fetchAll();


	if(array_key_exists('submit',$_POST)) { // Fetching variables of the form which travels in URL
		
	    //$content_dir = '../img/upload/'; // dossier où sera déplacé le fichier

	    // $tmp_file = $_FILES['images']['tmp_name'];

	    // if( !is_uploaded_file($tmp_file) )
	    // {
	    //     exit("Le fichier est introuvable");
	    // }

	    // // on vérifie maintenant l'extension
	    // $type_file = $_FILES['fichier']['type'];

	    // if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') )
	    // {
	    //     exit("Le fichier n'est pas une image");
	    // }

	    // // on copie le fichier dans le dossier de destination
	    // $name_file = $_FILES['fichier']['name'];

	    // if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
	    // {
	    //     exit("Impossible de copier le fichier dans $content_dir");
	    // }


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


		$stmt = $bdd -> prepare('INSERT INTO articles(titre, subtitle, datePublication, contenu, motsClefs, statut, imgUne, resume, dateEdition, categories_idCategories, users_idUsers) 
			VALUES (:titre, :subtitle, :datePublication, :contenu, :motsClefs, :statut, :imgUne, :resume, :dateEdition, :categorie, :idUsers)');
		$stmt -> execute(array(
				':titre' => $_POST['titre'],
				':subtitle' => $_POST['subtitle'],
				':datePublication' => ($_POST['publication']!='')?$_POST['publication']:date('Y-M-d'),
				':dateEdition' => ($_POST['edition']!='')?$_POST['edition']:date('Y-m-d'),
				':contenu' => $_POST['contenu'],
				':motsClefs' => $_POST['clefs'],
				':statut' => array_key_exists('statut', $_POST)?1:0,
				':imgUne' => $file_name,
				':resume' => $_POST['resume'],
				':categorie' => $_POST['categorie'],
				':idUsers' => $_SESSION['idUser']
				));
		// var_dump($_POST);
		header('Location:admin.php');
	}

}
catch(Exception $e)
{

	$erreur = 'Erreur  : '.$e->getMessage();
}



include 'tpl/new_article.phtml';