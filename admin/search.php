<?php

include('../config/sqlconnect.php');


 
if($_POST) {
    $input = $_POST['input'];
    
    $stmt = $bdd->prepare('SELECT titre FROM articles WHERE titre LIKE "%'.$input.'%"'); // Search matching elements in database

    $stmt->execute();

    $results = $stmt->fetchAll();

    if (!empty($results)) { // If not empty list
        echo '<ul id="matchList">'; // Create UL list
            foreach($results as $result) { // Loops
                $resultBold = preg_replace('/('.$input.')/i', '<strong>$1</strong>', $result['titre']); // Replace text field input by bold one
                echo '<li id="'.$result['titre'].'">'.$resultBold.'</li>'; // Create the matching list - we put maching name in the ID too
            }
        echo '</ul>';
    }
}