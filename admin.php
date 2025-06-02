<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des séniors inscrits</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <!-- En-tête de la page avec titre et zone utilisateur -->
  <header>
    <div class="left-header">Liste des séniors inscrits</div>
    <div class="right-header">
      <?php
        // Démarrage de la session et affichage du prénom de l'admin connecté
        session_start();
        $prenom=$_SESSION['prenom'];
        echo "<span class='greeting'>Bonjour $prenom</span>";
      ?>
      <!-- Bouton de déconnexion -->
      <a href="quitter.php"><button class="logout">Se déconnecter</button></a>
    </div>
  </header>

  <main>
    <!-- Bouton pour ajouter un nouveau senior -->
    <div class="add-button">
      <a href="inscription.html"><button>Ajouter un senior</button></a>
    </div>

    <!-- Liste des seniors inscrits -->
    <ul class="senior-list">
      <?php
        // Connexion à la base et récupération des comptes
        include("connexion.inc.php");
        $result = $cnx->query("SELECT * FROM prive.comptes WHERE numid != 0");
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
          // Affichage de chaque senior avec avatar, nom/prénom et bouton supprimer
          echo "<li><div class='avatar'></div>";
          echo "<span class='name'>$row->prenom $row->nom</span>";
          // Formulaire pour supprimer le compte du senior
          echo "<form action='supprimer_comptes.php' method='POST' >";
          echo "<label for='supp$row->numid' class='edit-btn'>Supprimer</label>";
          echo "<input type='submit' id='supp$row->numid' name='Supprimer' value='$row->numid' hidden>";
          echo "</form></li>";
        }
      ?>
    </ul>
  </main>
</body>
</html>
