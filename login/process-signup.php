<?php

// Podmínka - musí být vyplněné jméno
if (empty($_POST["name"])) {
    die("Name is required");
}

// Email musí být ve správné formě
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email required");
}

// Heslo musí bát delší než 8 znaků
if (strlen($_POST["password"]) < 8) {
    die ("Password must me at least 8 characters.");
}

// Heslo musí obsahovat alespoň jedno písmeno
if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

// Heslo musí obsahovat alespoň jedno číslo
if (! preg_match("/[0-9]/", $_POST["password"])) {
    die ("Password must contain at least one letter");
}

// Potvrzení hesla se musí shodovat s heslem
if ($_POST["password_confirmation"] !== $_POST["password"]) {
    die ("You entered wrong confirmation password.");
}
    
//zahashování hesla
$hash_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

//ZAVOLÁNÍ PŘIPOJENÍ DO DATABÁZE ZE SOUBORU database.php!
$connection = require __DIR__ . "/database.php";

//SQL query
$query = "INSERT INTO users (username, email, password) VALUES (?,?,?)";

//Vytvoření objektu pro dotaz
$stmt = $connection->stmt_init();
// ZKUS připravit query, navázat na query parametry, vykonat query
// Pokud něco selže, upozorni na chyby
try {
    // Kontrola, zda inicializace proběhla v pořádku
    if (!$stmt->prepare($query)) {
        die("SQL error: " . $connection->error);
    }
    // Navázání parametrů na (?,?,?) v SQL příkazu
    //$_POST parametry z formuláře a proměnná za zahashované heslo
    $stmt->bind_param("sss", $_POST["name"], $_POST["email"], $hash_password);

    // Vykonání příkazu pro zápis do databáze a přesměrování na signup-success.html
    if ($stmt->execute()) {
        header("Location: signup-success.html");
        exit;
    } else {
        die($connection->error . " " . $connection->errno);
    }
} catch (mysqli_sql_exception $e) {
    // Kontrola, zda jde o chybu duplicity
    if ($e->getCode() === 1062) { // 1062 = kód pro "Duplicate entry"
        echo "Email je již zaregistrován.";
    } else {
        // Ošetření jiných chyb
        echo "Chyba: " . $e->getMessage();
    }
}

?>