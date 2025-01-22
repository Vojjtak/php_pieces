<?php

$is_invalid = false;
// Po odeslání se připoj k serveru a načti tabulku users
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $connection = require __DIR__ . "/database.php";
    // Query a doplněni ochrany pro SQL injection
    $query = sprintf("SELECT * FROM users WHERE email = '%s'",
                     $connection->real_escape_string($_POST["email"]));
    // Zavolání query
    $result = $connection->query($query);
    // Vytvoření array pro uživatele
    $user = $result->fetch_assoc();
    
    // Ověření zda uživatel podle emailu existuje a match hesla a emailu
    if ($user) {
        if (password_verify($_POST["password"], $user["password"])) {
            session_start();
            // Zvýšení bezpečnosti proti session fixation
            session_regenerate_id();
            
            // Session id nastavena jako ID uživatele ze zadaného emailu
            $_SESSION["user_id"] = $user["id"];
            
            // Přesměrování na úvodní stránku index.php
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>


<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Signup</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        <link rel="stylesheet" href="styles/style.css">

    </head>

    <body>
      <h1>Login</h1>
         
         <?php if ($is_invalid): ?>
         <em>Invalid login</em>
         <?php endif; ?>
        <div class="centered_form">
      <form method="post">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" value="
          
          <?php 
             //zapamatování emailu v kolonce - vloženo php do input email
             echo htmlspecialchars($_POST['email'] ?? ''); ?>">


          <label for="password">Password</label>
          <input type="password" name="password" id="password">

          <button>Log in</button>
      </form>
      </div>



    </body>
</html>