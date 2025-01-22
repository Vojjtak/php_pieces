<?php

    // Obecné připojení do databáze
    $host = "localhost";
    $dbname = "loginaplication";
    $username = "root";
    $password = "";

    // Vytvoření connection - (Možné použít mysqli_connect())
    $connection = new mysqli($host, $username, $password, $dbname);
   
    if($connection->connect_errno) {
        die ("Connection error: ".$connection->connect_error);
    }

    return $connection;

?>