<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Menu</title>
  <link rel="stylesheet" href="index.css">
</head>

<body>
  <!-- En-tête avec bouton de connexion/déconnexion -->
  <header>
    <?php 
      session_start();
      if (!isset($_SESSION['nom'])) {
        // Si l'utilisateur n'est pas connecté, bouton de connexion
        echo "<a href='connexion.html'><button class='connecter'>Se connecter</button></a>";
      } else {
        // Si l'utilisateur est connecté, bouton de déconnexion
        echo "<a href='quitter.php'><button class='connecter'>Se déconnecter</button></a>";
      }
    ?>
  </header>

  <main>
    <div class="content"></div>
    <div class="menu">
      <?php 
        // Affichage du nom/prénom si connecté
        if(isset($_SESSION['nom'])) {
          echo "<h1>Bonjour ".$_SESSION['prenom']." ".$_SESSION['nom']."</h1>";
          echo "<a href='profil.php'>";
        } else {
          echo "<a href=''>";
        }
      ?>
        <!-- Menu Profil -->
        <div class="menu-item1">
          <svg width="100" height="100" viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 
                   10-4.486 10-10S17.514 2 12 2zm0 4a3 3 0 1 1 0 6 
                   3 3 0 0 1 0-6zm0 14c-2.5 0-4.71-1.28-6-3.22.03-1.99 
                   4-3.08 6-3.08s5.97 1.09 6 3.08C16.71 18.72 14.5 20 12 20z" />
          </svg>
          <span>Profil</span>
        </div></a>

      <?php 
        // Lien vers la messagerie si connecté
        if(isset($_SESSION['nom'])) {
          echo "<a href='messagerie.php'>";
        } else {
          echo "<a href=''>";
        }
      ?>
        <!-- Menu Messages & Contacts -->
        <div class="menu-item2">
          <svg width="100" height="100" viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H6l-4 4V6c0-1.1.9-2 2-2zm2 4v2h12V8H6zm0 4v2h8v-2H6z" />
          </svg>
          <span>Messages & Contacts</span>
        </div></a>

      <?php 
        // Lien vers le calendrier si connecté
        if(isset($_SESSION['nom'])) {
          echo "<a href='calendrier_perso.php'>";
        } else {
          echo "<a href=''>";
        }
      ?>
        <!-- Menu Calendrier -->
        <div class="menu-item3">
          <svg width="100" height="100" viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 
                   0-2 .89-2 2v14c0 1.11.89 2 
                   2 2h14c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 
                   16H5V9h14v11zm0-13H5V6h14v1z" />
          </svg>
          <span>Calendrier</span>
        </div></a>
    </div>
  </main>

</body>
</html>