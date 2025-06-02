<?php 
    // Démarre la session
    session_start();
    // Supprime toutes les variables de session
    session_unset();
    // Détruit la session
    session_destroy();
    // Redirige vers la page d'accueil
    header("location:index.php");
    exit();
?>