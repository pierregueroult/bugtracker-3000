<?php

// this file is used to create a ticket
// taking the title, the description and the tag as parameters

// if the parameters are not set, redirect to tickets page
if (!isset($_POST["title"], $_POST["description"], $_POST["tag"])) {
  header('Location: ../tickets/index.php?error=emptyData');
  die();
}

session_start();

// if the user is not connected, redirect to login page
if (!isset($_SESSION["user"])) {
  header('Location: ../account/login.php?error=notLogged');
  die();
}

// getting the data from the form
$title = $_POST["title"];
$description = $_POST["description"];
$tag = $_POST["tag"];
$userId = $_SESSION["user"]['idUser'];

// we initialize the database connection
include('../database/connection.php');

// sql command to insert the ticket
$sql = "INSERT INTO sae203_tickets (titleTicket, descriptionTicket, tagTicket, userId) VALUES (:title, :description, :tag, :userId)";

// we execute the sql command
try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    'title' => htmlentities($title),
    'description' => htmlentities($description),
    'tag' => htmlentities($tag),
    'userId' => intval(htmlentities($userId))
  ]);
} catch (PDOException $e) {
  header('Location: ../tickets/create.php?error=sqlError');
  die();
}

// we redirect to the tickets page
header('Location: ../tickets/index.php?success=ticketCreated');

die();

?>