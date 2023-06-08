<?php

// we import the secret file to get the database credentials
include('connection.secret.php');

try {
  // we initialize the database connection
  $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
  // we set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  // if the connection fails, we display the error
  echo "Connection failed: " . $e->getMessage();
}

?>