<?php

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: ../account/login.php?error=notConnected');
  die();
}

if ($_SESSION['user']['roleUser'] !== 'admin') {
  header('Location: ../account/login.php?error=notAdmin');
  die();
}

if (!isset($_POST['ticketId'], $_POST['dev'], $_POST['scale'])) {
  header('Location: ../tickets/index.php?error=missingData');
  die();
}

if ($_POST['dev'] === 'none' || $_POST['scale'] === 'none') {
  header('Location: ../tickets/index.php?error=missingData');
  die();
}

include('../database/connection.php');

$sql = "UPDATE sae203_tickets SET devId = :devId, statusTicket = 'assigned', assignedAt = NOW(), scaleTicket = :scaleTicket WHERE idTicket = :ticketId";

$stmt = $pdo->prepare($sql);
$stmt->execute(
  array(
    'devId' => htmlentities($_POST['dev']),
    'scaleTicket' => htmlentities($_POST['scale']),
    'ticketId' => htmlentities($_POST['ticketId'])
  )
);

header('Location: ../tickets/index.php?success=ticketAssigned');

?>