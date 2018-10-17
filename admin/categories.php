<?php
session_start();

require '../config/sqlconnect.php';

/* Si on est pas connecté on redirige vers la page login.php*/
if(!isset($_SESSION['connected']) || $_SESSION['connected'] == false)
header('Location:login.php');


$stmt = $bdd->prepare("SELECT *
	FROM categories");

$stmt->execute();

$results = $stmt->fetchAll();

include 'tpl/categories.phtml';
