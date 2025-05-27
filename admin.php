<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des séniors inscrits</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <header>
    <div class="left-header">Liste des séniors inscrits</div>
    <div class="right-header">
      <?php
        session_start();
        $prenom=$_SESSION['prenom'];
        echo "<span class='greeting'>Bonjour $prenom</span>";
      ?>
      <a href="quitter.php"><button class="logout">Se déconnecter</button></a>
    </div>
  </header>

  <main>
    <div class="add-button">
      <a href="inscription.html"><button>Ajouter un senior</button></a>
    </div>

    <ul class="senior-list">
      <!-- Exemple d'élément -->
       <?php
        include("connexion.inc.php");
        $result = $cnx->query("SELECT * FROM prive.comptes WHERE numid != 0");
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
          echo "<li><div class='avatar'></div>";
          echo "<span class='name'>$row->prenom $row->nom</span>";
          echo "<button class='edit-btn'>Modifier</button>";
          echo "</li>";
        }
       ?>
    </ul>
  </main>
</body>
</html>
