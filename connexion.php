<?php
    session_start();
    include("connexion.inc.php");
    if ((isset($_POST["id"]) && isset($_POST["mdp"])) && ($_POST["id"]!=null && $_POST["mdp"]!=null)) {
        $id=$_POST["id"];
        $mdp=$_POST["mdp"];
        $verif=$cnx->query("SELECT numid,nom,prenom FROM prive.comptes WHERE id LIKE '$id' AND mdp like '$mdp'");
        $ligne =$verif->fetch(PDO::FETCH_OBJ);
        if ($ligne!=null) {
            $_SESSION["id"]=$ligne->numid;
            $_SESSION["nom"]=$ligne->nom;
            $_SESSION["prenom"]=$ligne->prenom;
            header("location:index.php");
            exit();
        } else {
            header("location:index.php");
            exit();
        }
    } else {
        header("location:connexion.php");
        exit();
    }
?>
