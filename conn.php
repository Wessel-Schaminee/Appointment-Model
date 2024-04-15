<?php

// $server = "YOUR_SERVER_OR_LOCALHOST";
// $username = "YOUR_DATABASE_USERNAME";
// $password = "YOUR_USERNAME_PASSWORD";
// $dbname = "YOUR_DATABASE_NAME";

try {
    $conn = new PDO(
        "mysql:host=$server; dbname=$dbname",
        "$username",
        "$password"
    );

    $conn->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
} catch (PDOException $e) {
    die('Unable to connect with the database');
}

?>