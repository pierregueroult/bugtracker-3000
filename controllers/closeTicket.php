<?php

// this file is used to close a ticket
// taking the ticket id as parameter

session_start();

// if the user is not connected or if he is a user, redirect to login page
if (!isset($_SESSION['user'])) {
  header('Location: ../account/login.php?error=notConnected');
  die();
}
$role = $_SESSION['user']['roleUser'];
if ($role == 'user') {
  header('Location: ../tickets/index.php?error=notAllowed');
}

// if the parameter is not set, redirect to tickets page
if (!isset($_POST['id'])) {
  header('Location: ../tickets/index.php?error=notFound');
  die();
}

// we initialize the database connection
include('../database/connection.php');

// sql command to get the ticket
$sql = "SELECT * FROM sae203_tickets INNER JOIN sae203_users ON sae203_tickets.devId = sae203_users.idUser WHERE sae203_tickets.idTicket = :id";

// we execute the sql command
$stmt = $pdo->prepare($sql);
$stmt->execute(array('id' => htmlentities($_POST['id'])));

// we get the result
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// if the ticket is not found, redirect to tickets page
if (!$result) {
  header('Location: ../tickets/index.php?error=notFound');
  die();
}

// if the user is not the dev of the ticket and is not an admin, redirect to tickets page
if ($_SESSION['user']['idUser'] !== $result['devId'] && $_SESSION['user']['roleUser'] !== 'admin') {
  header('Location: ../tickets/index.php?error=notAllowed');
  die();
}

// sql command to update the ticket
$sql = "UPDATE sae203_tickets SET statusTicket = 'closed', closedAt = NOW() WHERE idTicket = :id";

// we execute the sql command
$stmt = $pdo->prepare($sql);
$id = htmlentities($_POST['id']);
$stmt->execute(array('id' => $id));

// we redirect to the tickets page
header('Location: ../tickets/index.php?success=closed');

?>