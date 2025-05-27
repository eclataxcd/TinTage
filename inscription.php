<?php
include("cnx_admin.inc.php");
$id = $_POST['id'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$adresse = $_POST['adresse'];
$mail = $_POST['mail'];
$naiss = $_POST['naiss'];
$mdp = $_POST['mdp'];
$result = $cnx -> query("SELECT COUNT(*) FROM prive.comptes");
$nb= $result->fetch(PDO::FETCH_OBJ);
$cnx -> exec("INSERT INTO prive.comptes VALUES ($nb->count, '$id', '$mdp', '$mail', '$naiss', '$nom', '$prenom', '$adresse')");
header("location:admin.php");
exit();
?>