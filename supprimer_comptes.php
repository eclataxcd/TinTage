<?php 
include("cnx_admin.inc.php");
try {
    if (isset($_POST['Supprimer'])) {
        $numid = $_POST['Supprimer'];
        // Suppression des messages liés à l'utilisateur
        $cnx->exec("DELETE FROM prive.historique_chat WHERE id_receveur = $numid OR id_envoyeur = $numid ");
        // Suppression des contacts liés à l'utilisateur
        $cnx->exec("DELETE FROM prive.contact WHERE compte1 = $numid OR compte2 = $numid");
        // Suppression des événements personnels liés à l'utilisateur
        $cnx->exec("DELETE FROM prive.calendrier_perso WHERE id_compte = $numid");
        // Suppression du compte utilisateur
        $cnx->exec("DELETE FROM prive.comptes WHERE numid = $numid");
    } 
} catch (PDOException $e) {
    echo "Erreur lors de la suppression du compte : " . $e;
}

// Redirection vers la page admin après suppression
header("Location: admin.php");
exit();
?>