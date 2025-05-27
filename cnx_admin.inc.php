<?php

$host = 'localhost'; 
$dbname = 'chat_senior'; 
$user = 'admin'; 
$password = 'frereCchaudLA<3'; 

try {
    $cnx = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
}
catch (PDOException $e) {
    echo "ERREUR : La connexion a échouée\n";
    echo "Error: " . $e;

}

?>