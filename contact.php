<?php
    // Démarrage de la session pour récupérer l'utilisateur connecté
    session_start();
    // Stocke l'identifiant du contact sélectionné dans la session
    $_SESSION["id_r"] = $_POST['contact'];
    // Affiche les données POST pour debug (optionnel)
    print_r($_POST);
    // Redirige vers la page de messagerie
    header("location:messagerie.php");
    exit();
?>