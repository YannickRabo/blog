<?php
session_start();
require '../config/sqlconnect.php';


if(array_key_exists('delCat', $_GET)) {
	$delete = $bdd->prepare('DELETE FROM categories WHERE idCategories = ?');
	$delete -> execute(array($_GET['delCat']));
}
header('location:categories.php');