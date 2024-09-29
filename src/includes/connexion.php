<?php

    // Informations de connexion à la base de données
    $host = "localhost";  //l'adresse serveur MySQL
    $username = "root";   //nom d'utilisateur MySQL
    $password = "root";       //mot de passe MySQL
    $database = "socialnetwork"; //nom de la base de données

    // Création de la connexion, assigné à la variable mysqli
    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

    // Vérification de la connexion
    if ($mysqli->connect_errno) {
        echo("Échec de la connexion : " . $mysqli->connect_error);
        exit(); // Arrête l'exécution du script en cas d'erreur
    }

?>