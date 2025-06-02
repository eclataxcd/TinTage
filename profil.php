<!DOCTYPE html>
<html lang="fr">

<?php
// Démarrage de la session et récupération de l'utilisateur connecté
session_start();
include('connexion.inc.php');
$id = $_SESSION['id'];
// Récupérer les infos du compte connecté
$stmt = $cnx->query("SELECT * FROM prive.comptes WHERE numid = $id");
$user = $stmt->fetch(PDO::FETCH_OBJ);

// Calcul de l'âge de l'utilisateur
$birth = new DateTime($user->date_naissance);
$today = new DateTime();
$age = $today->diff($birth)->y;
?>

<head>
  <meta charset="UTF-8">
  <title>Profil JP P</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="profile">
    <!-- Bouton retour vers l'accueil -->
    <a href="index.php" class="back-button"><i class="fas fa-arrow-left"></i></a>
    <div class="top-banner">
      <!-- Image de profil (à personnaliser si besoin) -->
      <img src="" alt="Photo de profil" class="avatar">
    </div>

    <div class="info">
      <?php 
      // Affichage du nom, prénom et âge
      echo "<h1>$user->nom $user->prenom</h1>";
      echo "<p class='age'>$age ans <p>";
      ?>
    </div>

    <div class="biography">
      <ul>
        <!-- Affichage de l'email et de l'adresse -->
        <li><i class="fas fa-info-circle"></i> <?php echo $user->email ?></li>
        <li><i class="fas fa-location-dot"></i> <?php echo $user->adresse ?></li>
      </ul>
    </div>
    
  </div>
</body>

</html>