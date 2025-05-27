<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Messagerie</title>
  <link rel="stylesheet" href="messagerie.css">
</head>
<body>
  <div class="container">
    <div class="contacts">
      <h2>Contacts</h2>
      <ul>
        <?php
          session_start();
          include("connexion.inc.php");
          $id=$_SESSION["id"];
          $verif=$cnx->query("SELECT c.nom, c.prenom, c.numid FROM prive.contact ct JOIN prive.comptes c ON (c.numid = ct.compte1 AND ct.compte2 = $id) OR (c.numid = ct.compte2 AND ct.compte1 = $id); ");
          echo "<form action='contact.php' method='post'>";
          while ($ligne =$verif->fetch(PDO::FETCH_OBJ)) {
            echo "<input type='submit' value='$ligne->numid' name='contact' id='contact$ligne->numid' hidden>";
            echo "<label for='contact$ligne->numid'><li><span class='avatar'></span>$ligne->nom $ligne->prenom</li></label>";
          }
          echo "</form>";
        ?>
      </ul>
      <form action="ajout_contact.php" method="post">
        <input type="mail" name="mail" placeholder="Ajouter un contact" >
        <input type="submit" value="Ajouter" id="ajout_contact">
      </form>
    </div>

    <div class="chat">
      <div class="chat-header">
        <div>
          <span class="avatar"></span>
          <?php
            echo "<span class='name'>".$_SESSION['prenom']." ".$_SESSION['nom']."</span>";
          ?>
        </div>
        <a href="index.php"><button type="button" class="btn-retour">Retour</button></a>
        
      </div>
      <div class="chat-messages">
         <?php 
          if (isset($_SESSION["id_r"])) {
            $messages=$cnx->query("SELECT * FROM prive.historique_chat ORDER BY date_envoi,heure_envoi");
            while ($ligne =$messages->fetch(PDO::FETCH_OBJ)) {
              $date = new DateTime($ligne->date_envoi);
              $dt = $date->format('d/m/Y');
              $heure = new DateTime($ligne->heure_envoi);
              $h = $heure->format('H:i');
              if ($ligne->message != null) {
                if (($ligne->id_envoyeur == $_SESSION["id"]) && ($ligne->id_receveur == $_SESSION["id_r"])) {
                  echo "<div class='message sent'>$ligne->message<p class='envoi'>Envoyé le $dt à $h</p></div>";
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
