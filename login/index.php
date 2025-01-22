<?php

session_start();

// Oveření zda se id uživatele který nastartoval seasson shoduje s přihlášeným uživatelem z globální $_SEASSON
if(isset($_SESSION["user_id"])) {
    $connection = require __DIR__ . "/database.php";
    // Najdi uživatele který se shoduje se session id. Pokud existuje.
    $query = "SELECT * FROM users WHERE id={$_SESSION["user_id"]}";
    
    $result = $connection->query($query);
    
    $user = $result->fetch_assoc();
    
}


?>


<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

    </head>

    <body>
      <h1>Home</h1>
      
      <?php if(isset($user)): ?>
          <p>Zdarec <?= htmlspecialchars($user["username"]); ?></p>

          <p>Můžeš se podívat na <a href="test.php">Test PHP</a>, ale jen jestli jsi řádně přihlášen</p>
          <p><a href="logout.php">Log out</a></p>
          
          <?php else: ?>
          <p><a href="login.php">Log in</a> or <a href="signup.html">Sign up</a></p>
          
          <?php endif; ?>
      
      
    </body>
    
</html>