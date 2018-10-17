<?php
session_start();
include '../config/sqlconnect.php';

//Si erreur à afficher
$error='';

//Pour réinjecter l'utilisateur dans le formulaire si mauvais mot de passe
$user = '';

/* Le formulaire est posté */
if(isset($_POST['username']) && $_POST['username']!='' &&  $_POST['password']!='')
{
  $username = htmlspecialchars($_POST['username']);
  $mdp = htmlspecialchars(sha1($_POST['password']));

	/* Recupérer mot de passe et username
	rechercher dans la base si une ligne existe avec ce couple passe username
	si cette ligne existe alors je connecte l'utilisateur en definissant une variable session_cache_expire
	*/ 
  try{
    $bdd = new PDO('mysql:host=ynkrabofecyrabo.mysql.db;dbname=ynkrabofecyrabo;charset=utf8','ynkrabofecyrabo', 'Yannick140486');

  	$stmt = $bdd->prepare('SELECT idUsers,userName,nom,prenom FROM blogUsers WHERE password=? AND userName=?');
  	$result = $stmt->execute(array($mdp,$username));

  	$result = $stmt->fetch();

    if($result)
  	{
    		$_SESSION['connected'] = true;
        $_SESSION['userName'] = $result['userName'];
        $_SESSION['userFullName'] = $result['prenom'].' '.$result['nom'];
        $_SESSION['idUser'] = $result['idUsers'];

        //On redirige vers la page d'accueil
        header('Location:admin.php');
  	}
  	else
  	{
  		$error.= 'Connexion impossible';
  		$_SESSION['connected'] = false;
      unset($_SESSION['userName']);
      header('Location:login');


  	}
  }
  catch(Exception $e)
  {
      $error.= 'Il est actuellement impossible de se connecter sur notre serveur.';
  }
}
elseif(isset($_POST['user']) && ($_POST['user']=='' || $_POST['password']==''))
{
    $error.= 'Merci de remplir tous les champs.';
}
include 'tpl/connexion.phtml';
