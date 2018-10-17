<?php
session_start();
require '../config/sqlconnect.php';

/* Si on est pas connecté on redirige vers la page login.php*/
if(!isset($_SESSION['connected']) || $_SESSION['connected'] == false)
header('Location:login.php');

/* EDITER */

if(array_key_exists('idUser', $_GET))
{
	$idUser = $_GET['idUser'];
	//SELECTIONNER DONNÉES USER ET INJECTER DANS LE FORMULAIRE
	$stmt = $bdd->prepare('SELECT * FROM blogUsers WHERE idUsers = ?');

	$stmt->execute(array($idUser));

	$users = $stmt -> fetch(PDO::FETCH_ASSOC);

}

if(array_key_exists('submit', $_POST)) {

	$edit = $bdd->prepare('UPDATE blogUsers 
		SET userName=:username, password=:password, nom=:nom, prenom=:prenom, email=:email
		WHERE idUsers = :idUsers');
	$edit -> execute(
		array( 
		'username' => $_POST['username'],
		'password' => sha1($_POST['password']),
		'nom' => $_POST['nom'],
		'prenom' => $_POST['prenom'],
		'email' => $_POST['email'],
		'idUsers' => $_POST['idUsers']
		));
	header('location:users.php');
}
	
include 'tpl/edit_user.phtml';

?>