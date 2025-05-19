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
          $verif=$cnx->query("SELECT nom,prenom FROM prive.comptes JOIN prive.historique_chat ON numid=id_receveur WHERE id_envoyeur=$id");
          

        ?>
        <li><span class="avatar"></span>Gertrude Befroi</li>
        <li><span class="avatar"></span>King Julian</li>
        <li><span class="avatar"></span>Micheal Jackson</li>
        <li><span class="avatar"></span>Marie Pierre Béal</li>
        <li><span class="avatar"></span>Rodolphe Buzz L’Éclair</li>
        <li><span class="avatar"></span>Caroline Dubois</li>
        <li><span class="avatar"></span>Fabrice PotDeFleur</li>
        <li><span class="avatar"></span>Marguerite Poulain</li>
        <li><span class="avatar"></span>Georges Monsaton</li>
      </ul>
    </div>

    <div class="chat">
      <div class="chat-header">
        <div>
          <span class="avatar"></span>
          <span class="name">Jean Pierre Pernault</span>
        </div>
        <a href="index.html"><button type="button" class="btn-retour">Retour</button></a>
        
      </div>
      <div class="chat-messages">
        
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
