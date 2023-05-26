<?php

if (!isset($_POST["title"], $_POST["description"], $_POST["tag"])) {
  header('Location: ../tickets/index.php?error=emptyData');
  die();
}

session_start();

if (!isset($_SESSION["user"])) {
  header('Location: ../account/login.php?error=notLogged');
  die();
}


$title = $_POST["title"];
$description = $_POST["description"];
$tag = $_POST["tag"];
$userId = $_SESSION["user"]['idUser'];

include('../database/connection.php');

$sql = "INSERT INTO sae203_tickets (titleTicket, descriptionTicket, tagTicket, userId) VALUES (:title, :description, :tag, :userId)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
  'title' => htmlentities($title),
  'description' => htmlentities($description),
  'tag' => htmlentities($tag),
  'userId' => intval(htmlentities($userId))
]);


header('Location: ../tickets/index.php?success=ticketCreated');

die();

?>