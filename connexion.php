<?php
    // Démarrage de la session
    session_start();
    // Inclusion du fichier de connexion à la base de données
    include("connexion.inc.php");

    // Vérification que les champs id et mdp sont bien envoyés et non vides
    if ((isset($_POST["id"]) && isset($_POST["mdp"])) && ($_POST["id"]!=null && $_POST["mdp"]!=null)) {
        $id = $_POST["id"];
        $mdp = $_POST["mdp"];
        // Requête pour vérifier l'identifiant et le mot de passe
        $verif = $cnx->query("SELECT numid, nom, prenom FROM prive.comptes WHERE id LIKE '$id' AND mdp like '$mdp'");
        $ligne = $verif->fetch(PDO::FETCH_OBJ);
        if ($ligne != null) {
            // Si l'utilisateur existe, on enregistre les infos en session
            $_SESSION["id"] = $ligne->numid;
            $_SESSION["nom"] = $ligne->nom;
            $_SESSION["prenom"] = $ligne->prenom;
            // Si c'est l'admin (numid = 0), redirection vers l'admin
            if ($_SESSION["id"] == 0) {
                header("location:admin.php");
                exit();
            }
            // Sinon, redirection vers la page d'accueil utilisateur
            header("location:index.php");
            exit();
        } else {
            // Identifiants incorrects, retour à l'accueil
            header("location:index.php");
            exit();
        }
    } else {
        // Champs non remplis, retour au formulaire de connexion
        header("location:connexion.php");
        exit();
    }
?>
