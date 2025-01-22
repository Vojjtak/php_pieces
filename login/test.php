<?php

session_start();

// Ověření zda je uživatel přihlášený (pokud existuje $_SESSION["user_id"])
if (!isset($_SESSION["user_id"])) {
    // Pokud není přihlášený, přesměrujeme na index.php
    header("Location: index.php");
    exit; // Ukončí skript, aby se kód dál neprováděl
}

$connection = require __DIR__ . "/database.php";

// Najdi uživatele, který se shoduje se session id, pokud existuje
$query = "SELECT * FROM users WHERE id={$_SESSION['user_id']}";
$result = $connection->query($query);

// Pokud uživatel existuje, načteme data do proměnné $user
$user = $result->fetch_assoc();

?>



<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Signup</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

    </head>

    <body>
      <h1>Nazdar bazar</h1>
      
      
      <?php if(isset($user)): ?>
          <p>Zdarec, jsi přihlášený jako : <?= htmlspecialchars($user["username"]); ?></p>

          
          <p><a href="logout.php">Log out</a></p>
          
          <?php else: ?>
          <p><a href="login.php">Log in</a> or <a href="signup.html">Sign up</a></p>
          
          <?php endif; ?>
      
      
    </body>
   
</html>
