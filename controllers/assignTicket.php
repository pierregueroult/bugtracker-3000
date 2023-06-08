<?php

// this file is used to assign a ticket to a dev
// taking the ticket id, the dev id and the scale as parameters

session_start();

// if the user is not connected or is not an admin, redirect to login page
if (!isset($_SESSION['user'])) {
  header('Location: ../account/login.php?error=notConnected');
  die();
}
if ($_SESSION['user']['roleUser'] !== 'admin') {
  header('Location: ../account/login.php?error=notAdmin');
  die();
}

// is the parameters are not set, redirect to tickets page
if (!isset($_POST['ticketId'], $_POST['dev'], $_POST['scale'])) {
  header('Location: ../tickets/index.php?error=missingData');
  die();
}
if ($_POST['dev'] === 'none' || $_POST['scale'] === 'none') {
  header('Location: ../tickets/index.php?error=missingData');
  die();
}

// we initialize the database connection
include('../database/connection.php');

// sql command to update the ticket
$sql = "UPDATE sae203_tickets SET devId = :devId, statusTicket = 'assigned', assignedAt = NOW(), scaleTicket = :scaleTicket WHERE idTicket = :ticketId";

// we execute the sql command
try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute(
    array(
      'devId' => htmlentities($_POST['dev']),
      'scaleTicket' => htmlentities($_POST['scale']),
      'ticketId' => htmlentities($_POST['ticketId'])
    )
  );
} catch (PDOException $e) {
  header('Location: ../tickets/index.php?error=sqlError');
  die();
}

// we redirect to the tickets page
header('Location: ../tickets/index.php?success=ticketAssigned');

?>