<?php
session_start();
$erreur = '';

/* Si on est pas connecté on redirige vers la page login.php*/
if(!isset($_SESSION['connected']) || $_SESSION['connected'] == false)
header('Location:login.php');

try
{

	require '../config/sqlconnect.php';

	if(array_key_exists('submit',$_POST)) { 


		$stmt = $bdd -> prepare('INSERT INTO categories(titre) 
			VALUES (:category)');
		$stmt -> execute(array(
				':category' => ($_POST['category']),
				));
		// var_dump($_POST);
		header('Location:categories.php');
	}

}
catch(Exception $e)
{

	$erreur = 'Erreur  : '.$e->getMessage();
}



include 'tpl/new_category.phtml';