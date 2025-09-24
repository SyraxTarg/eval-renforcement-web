<?php
    $config = parse_ini_file('/var/www/config.ini');
    $host = $config["host"];
    $username = $config["username"];
    $password = $config["password"];
    $db = $config["db"];
    $port=$config["port"];

    // Connexion avec pdo mysql
    $db = new PDO("mysql:host=$host;port=$port;dbname=$db", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
?>