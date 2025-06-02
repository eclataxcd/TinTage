<?php
// Démarrage de la session pour récupérer l'utilisateur connecté
session_start();
$id = $_SESSION['id'];
$id_event = intval($_GET['id_event']);
include('connexion.inc.php');
try {
    // 1. Récupérer l'événement dans calendrier_evenement
    $stmt = $cnx->prepare("SELECT * FROM prive.calendrier_evenement WHERE id_event = :id_event");
    $stmt->execute(['id_event' => $id_event]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($event) {
        // 2. Insérer l'événement dans le calendrier personnel de l'utilisateur
        $insert = $cnx->prepare("
            INSERT INTO prive.calendrier_perso (id_compte, id_event, date_event, horaire_event, objet_event)
            VALUES (:id_compte, :id_event, :date_event, :horaire_event, :objet_event)
        ");
        $insert->execute([
            'id_compte'     => $id,
            'id_event'      => $event['id_event'],
            'date_event'    => $event['date_event'],
            'horaire_event' => $event['horaire_event'],
            'objet_event'   => $event['objet_event']
        ]);
    } 
} catch (PDOException $e) {
    // Gestion des erreurs PDO
    // echo "Erreur : " . $e->getMessage();
}
// Redirection vers la page des événements après l'ajout
header("Location: calendrier_evenements.php");
exit;
?>