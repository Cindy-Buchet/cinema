<?php
    // Afficher les erreurs
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Connexion à la base de données
    
    

    $pdo = new PDO('mysql:host=' .$host . ';dbname=' . $dbname . ';charset=utf8', $user, $passwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>