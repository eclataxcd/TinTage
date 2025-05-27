<?php 
session_start();
include("connexion.inc.php");
try {
    $id_envoyeur = $_SESSION["id"];
    $id_receveur = $_POST['send'];
    $message = $_POST['message'];
    $cnx->exec("INSERT INTO prive.historique_chat VALUES ($id_envoyeur, $id_receveur, current_date, current_time,'$message')");
} catch (PDOException $e) {
    header("location:messagerie.php");
    exit();
}
header("location:messagerie.php");
exit();
?>
