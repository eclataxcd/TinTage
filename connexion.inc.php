<?php

/*
 
création d'objet PDO de la connexion qui sera représenté par la variable $cnx*/
$host = 'localhost'; 
$dbname = 'chat_senior'; 
$user = 'utilisateur'; 
$password = 'aa'; 

try {
    // Création de l'objet PDO pour la connexion
    $cnx = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
}
catch (PDOException $e) {
    echo "ERREUR : La connexion a échouée";

 /* Utiliser l'instruction suivante pour afficher le détail de erreur sur la
 
page html. Attention c'est utile pour débugger mais cela affiche des
informations potentiellement confidentielles donc éviter de le faire pour un
site en production.*/
echo "Error: " . $e;

}

?>