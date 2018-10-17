<?php
session_start();
$_SESSION['connected'] = false;
unset($_SESSION['userName']);
header('Location:login.php');
