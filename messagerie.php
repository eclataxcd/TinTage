<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Messagerie</title>
  <link rel="stylesheet" href="messagerie.css">
</head>
<body>
  <div class="container">
    <!-- Colonne des contacts -->
    <div class="contacts">
      <h2>Contacts</h2>
      <ul>
        <?php
          // Démarrage session et connexion à la base
          session_start();
          include("connexion.inc.php");
          $id=$_SESSION["id"];
          // Récupération des contacts de l'utilisateur
          $verif=$cnx->query("SELECT c.nom, c.prenom, c.numid FROM prive.contact ct JOIN prive.comptes c ON (c.numid = ct.compte1 AND ct.compte2 = $id) OR (c.numid = ct.compte2 AND ct.compte1 = $id); ");
          echo "<form action='contact.php' method='post'>";
          while ($ligne =$verif->fetch(PDO::FETCH_OBJ)) {
            // Un bouton caché pour chaque contact, cliquable via le label
            echo "<input type='submit' value='$ligne->numid' name='contact' id='contact$ligne->numid' hidden>";
            echo "<label for='contact$ligne->numid'><li><span class='avatar'></span>$ligne->nom $ligne->prenom</li></label>";
          }
          echo "</form>";
        ?>
      </ul>
      <!-- Formulaire pour ajouter un contact par email -->
      <form action="ajout_contact.php" method="post">
        <input type="mail" name="mail" placeholder="Ajouter un contact" >
        <input type="submit" value="Ajouter" id="ajout_contact">
      </form>
    </div>

    <!-- Zone de chat principale -->
    <div class="chat">
      <div class="chat-header">
        <div>
          <span class="avatar"></span>
          <?php
          // Affichage du nom du contact sélectionné
          if (isset($_SESSION["id_r"])) {
            $id_r = $_SESSION["id_r"];
            $verif_r=$cnx->query("SELECT nom, prenom FROM prive.comptes WHERE numid = $id_r");
            $ligne_r = $verif_r->fetch(PDO::FETCH_OBJ);
            echo "<span class='name'>".$ligne_r->prenom ." ".$ligne_r->nom."</span>";
          } else {
            echo "<span class='name'>Sélectionnez un contact</span>";
          }
          ?>
        </div>
        <a href="index.php"><button type="button" class="btn-retour">Retour</button></a>
      </div>
      <div class="chat-messages">
         <?php 
          // Affichage des messages si un contact est sélectionné
          if (isset($_SESSION["id_r"])) {
            $messages=$cnx->query("SELECT * FROM prive.historique_chat ORDER BY date_envoi,heure_envoi");
            while ($ligne =$messages->fetch(PDO::FETCH_OBJ)) {
              $date = new DateTime($ligne->date_envoi);
              $dt = $date->format('d/m/Y');
              $heure = new DateTime($ligne->heure_envoi);
              $h = $heure->format('H:i');
              if ($ligne->message != null) {
                // Message envoyé par l'utilisateur
                if (($ligne->id_envoyeur == $_SESSION["id"]) && ($ligne->id_receveur == $_SESSION["id_r"])) {
                  echo "<div class='message sent'>$ligne->message<p class='envoi'>Envoyé le $dt à $h</p></div>";
                // Message reçu de l'autre utilisateur
                } elseif (($ligne->id_envoyeur == $_SESSION["id_r"]) && ($ligne->id_receveur == $_SESSION["id"])) {
                  echo "<div class='message received'>$ligne->message<p class='envoi'>Envoyé le $dt à $h</p></div>";
                }
              }
            }
          }
        ?>
      </div>
      <div class="chat-input">
        <button class="plus">+</button>
        <!-- Formulaire d'envoi de message -->
        <form action="envoi_message.php" method='post'>
          <?php
            if (isset($_SESSION["id_r"])) {
              $id_r = $_SESSION["id_r"];
              echo "<input type='text' placeholder='Texte' name='message' id='message'>";
              echo "<input type='submit' value='$id_r' hidden name='send' id='send'> ";
              echo "<label for='send' class='send'>➤</label>";
            } else {
              echo "<input type='text' placeholder='Texte'>";
              echo "<button class='send'>➤</button>";
            }
          ?>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
