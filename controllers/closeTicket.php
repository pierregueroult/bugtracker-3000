<?php

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: ../account/login.php?error=notConnected');
  die();
}

if (!isset($_POST['id'])) {
  header('Location: ../tickets/index.php?error=notFound');
  die();
}

$role = $_SESSION['user']['roleUser'];

if ($role == 'user') {
  header('Location: ../tickets/index.php?error=notAllowed');
}

include('../database/connection.php');

$sql = "SELECT * FROM sae203_tickets INNER JOIN sae203_users ON sae203_tickets.devId = sae203_users.idUser WHERE sae203_tickets.idTicket = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute(array('id' => htmlentities($_POST['id'])));

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
  header('Location: ../tickets/index.php?error=notFound');
  die();
}

if ($_SESSION['user']['idUser'] !== $result['devId'] && $_SESSION['user']['roleUser'] !== 'admin') {
  header('Location: ../tickets/index.php?error=notAllowed');
  die();
}

$id = htmlentities($_POST['id']);

$sql = "UPDATE sae203_tickets SET statusTicket = 'closed', closedAt = NOW() WHERE idTicket = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute(array('id' => $id));

header('Location: ../tickets/index.php?success=closed');

?>