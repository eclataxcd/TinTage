<?php
// Démarre la session pour récupérer l'utilisateur connecté
session_start();
$id = $_SESSION['id'];
$id_event = intval($_GET['id_event']);
include('connexion.inc.php');
try {
    // Suppression de l'événement du calendrier personnel de l'utilisateur
    $stmt = $cnx->prepare("DELETE FROM prive.calendrier_perso WHERE id_compte = :id AND id_event = :id_event");
    $stmt->execute([
        'id' => $id,
        'id_event' => $id_event
    ]);
} catch (PDOException $e) {
    // Affiche une erreur si la suppression échoue
    echo "Erreur : " . $e;
}
// Redirige vers le calendrier personnel après la suppression
header("Location: calendrier_perso.php");
exit;
?>