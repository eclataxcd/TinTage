<?php
// Démarrage de la session pour récupérer l'utilisateur connecté
session_start();
include("connexion.inc.php");
try {
    // Récupération de l'email du contact à ajouter depuis le formulaire
    $mail = $_POST['mail'];
    $id = $_SESSION['id'];
    // Recherche du compte correspondant à l'email
    $resultat = $cnx->query("SELECT numid FROM prive.comptes WHERE email='$mail'");
    $l = $resultat->fetch(PDO::FETCH_OBJ);
    $id2 = $l->numid;
    // Insertion du contact dans la table contact
    $cnx->exec("INSERT INTO prive.contact VALUES ($id, $id2)");
} catch (PDOException $e) {
    // En cas d'erreur, retour à la messagerie
    header("Location: messagerie.php");
    exit();
}
// Retour à la messagerie après l'ajout
header("Location: messagerie.php");
exit();
?>