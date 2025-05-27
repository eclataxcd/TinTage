<?php
session_start();
include("connexion.inc.php");
try {
    $mail=$_POST['mail'];
    $id=$_SESSION['id'];
    $resultat = $cnx->query("SELECT numid FROM prive.comptes WHERE email='$mail'");
    $l=$resultat->fetch(PDO::FETCH_OBJ);
    $id2=$l->numid;
    $cnx->exec("INSERT INTO prive.contact VALUES ($id, $id2)");
} catch (PDOException $e) {
    header("Location: messagerie.php");
    exit();
}
header("Location: messagerie.php");
exit();
?>