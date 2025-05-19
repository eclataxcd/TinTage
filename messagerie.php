<!DOCTYPE html>
<html lang="fr">
<head>
  <meta http-equiv="refresh" content="5">
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
          $verif=$cnx->query("SELECT DISTINCT nom,prenom,numid FROM prive.comptes JOIN prive.historique_chat ON numid=id_receveur WHERE id_envoyeur=$id");
          while ($ligne =$verif->fetch(PDO::FETCH_OBJ)) {
            echo "<a href='contact.php'><li><span class='avatar'></span>$ligne->nom $ligne->prenom</li></a>";
          }
          
        ?>
      </ul>
    </div>

    <div class="chat">
      <div class="chat-header">
        <div>
          <span class="avatar"></span>
          <?php
            echo "<span class='name' id=''>".$_SESSION['prenom']." ".$_SESSION['nom']."</span>";
          ?>
        </div>
        <a href="index.html"><button type="button" class="btn-retour">Retour</button></a>
        
      </div>
      <div class="chat-messages">
         <?php 
          $messages=$cnx->query("SELECT id_envoyeur,id_receveur,message FROM prive.historique_chat ORDER BY date_envoi,heure_envoi");
          while ($ligne =$messages->fetch(PDO::FETCH_OBJ)) {
            
            echo "<div class='message'><div class='received'>$ligne->message</div></div>";
          }
        ?>
      </div>
      <div class="chat-input">
        <button class="plus">+</button>
        <input type="text" placeholder="Texte">
        <button class="send">➤</button>
      </div>
    </div>
  </div>
</body>
</html>
