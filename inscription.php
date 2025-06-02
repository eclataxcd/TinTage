<?php
// Connexion à la base de données
include("cnx_admin.inc.php");

// Récupération des données du formulaire
$id = $_POST['id'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$adresse = $_POST['adresse'];
$mail = $_POST['mail'];
$naiss = $_POST['naiss'];
$mdp = $_POST['mdp'];

// Récupère le dernier numid pour générer le prochain identifiant unique
$result = $cnx -> query("SELECT * FROM prive.comptes ORDER BY numid DESC LIMIT 1");
$nb = $result->fetch(PDO::FETCH_OBJ);
$num_id = $nb->numid + 1;

// Insertion du nouveau compte dans la base de données
$cnx -> exec("INSERT INTO prive.comptes VALUES ($num_id, '$id', '$mdp', '$mail', '$naiss', '$nom', '$prenom', '$adresse')");

// Redirection vers la page admin après inscription
header("location:admin.php");
exit();
?>