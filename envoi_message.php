<?php 
// Démarrage de la session pour récupérer l'utilisateur connecté
session_start();
include("connexion.inc.php");
try {
    // Récupération des identifiants et du message depuis le formulaire
    $id_envoyeur = $_SESSION["id"];
    $id_receveur = $_POST['send'];
    $message = $_POST['message'];
    // Insertion du message dans la table historique_chat
    $cnx->exec("INSERT INTO prive.historique_chat VALUES ($id_envoyeur, $id_receveur, current_date, current_time,'$message')");
} catch (PDOException $e) {
    // En cas d'erreur, retour à la messagerie
    header("location:messagerie.php");
    exit();
}
// Redirection vers la messagerie après l'envoi
header("location:messagerie.php");
exit();
?>
