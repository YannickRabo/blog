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


		$stmt = $bdd -> prepare('INSERT INTO blogUsers(userName, nom, prenom, email, password) 
			VALUES (:username, :nom, :prenom, :email, :password)');
		$stmt -> execute(array(
				':username' => ($_POST['username']),
				':password' => sha1($_POST['password']),
				':nom' => $_POST['nom'],
				':prenom' => $_POST['prenom'],
				':email' => $_POST['email']
				));
		// var_dump($_POST);
		header('Location:users.php');
	}

}
catch(Exception $e)
{

	$erreur = 'Erreur  : '.$e->getMessage();
}



include 'tpl/new_user.phtml';