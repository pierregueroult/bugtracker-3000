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

$sql = "SELECT * FROM sae203_tickets WHERE idTicket = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute(array('id' => htmlentities($_POST['id'])));

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
  header('Location: ../tickets/index.php?error=notFound');
  die();
}

$id = htmlentities($_POST['id']);
$title = htmlentities($_POST['title']);
$description = htmlentities($_POST['description']);

if (isset($_POST['devId'], $_POST['scale'])) {
  $devId = htmlentities($_POST['devId']);
  $scale = htmlentities($_POST['scale']);

  $sql = "UPDATE sae203_tickets SET titleTicket = :title, descriptionTicket = :description, devId = :devId, scaleTicket = :scale, statusTicket = :status, assignedAt = NOW() WHERE idTicket = :id";

  $prepareArray = array(
    'title' => $title,
    'description' => $description,
    'devId' => $devId,
    'scale' => $scale,
    'status' => 'assigned',
    'id' => $id
  );
} else {
  $sql = "UPDATE sae203_tickets SET titleTicket = :title, descriptionTicket = :description WHERE idTicket = :id";

  $prepareArray = array(
    'title' => $title,
    'description' => $description,
    'id' => $id
  );
}

$stmt = $pdo->prepare($sql);
$stmt->execute($prepareArray);

header('Location: ../tickets/ticket?id=' . $id . '&success=ticketModified');


?>