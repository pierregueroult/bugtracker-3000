<?php

// this file is used to modify a ticket
// taking the ticket id, the title and the description as parameters

session_start();

// if the user is not connected, redirect to login page
if (!isset($_SESSION['user'])) {
  header('Location: /sae203/account/login.php?error=notConnected');
  die();
}

// if the parameters are not set, redirect to tickets page
if (!isset($_POST['id'])) {
  header('Location: /sae203/tickets/index.php?error=notFound');
  die();
}

// we take the user role
$role = $_SESSION['user']['roleUser'];

// if the user is not an admin or a dev, redirect to tickets page
if ($role == 'user') {
  header('Location: /sae203/tickets/index.php?error=notAllowed');
}

// we initialize the database connection
include('../database/connection.php');

// sql command to get the ticket
$sql = "SELECT * FROM sae203_tickets WHERE idTicket = :id";

// we execute the sql command
$stmt = $pdo->prepare($sql);
$stmt->execute(array('id' => htmlentities($_POST['id'])));
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// if the ticket is not found, redirect to tickets page
if (!$result) {
  header('Location: /sae203/tickets/index.php?error=notFound');
  die();
}

// we take the data from the form
$id = htmlentities($_POST['id']);
$description = htmlentities($_POST['description']);

// if devId form data and the scale form are set, we take it
if (isset($_POST['devId'], $_POST['scale'], $_POST['title'])) {

  // we take more the data from the form
  $devId = htmlentities($_POST['devId']);
  $scale = htmlentities($_POST['scale']);
  $title = htmlentities($_POST['title']);

  // sql command to update the ticket
  $sql = "UPDATE sae203_tickets SET titleTicket = :title, descriptionTicket = :description, devId = :devId, scaleTicket = :scale, statusTicket = :status, assignedAt = NOW() WHERE idTicket = :id";

  // we prepare the array to execute the sql command
  $prepareArray = array(
    'title' => $title,
    'description' => $description,
    'devId' => $devId,
    'scale' => $scale,
    'status' => 'assigned',
    'id' => $id
  );

  try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($prepareArray);
  } catch (PDOException $e) {
    header('Location: /sae203/tickets/index.php?error=sqlError');
    die();
  }
} else {
  // sql command to update the ticket in the other case (without devId and scale)
  if ($_SESSION['user']['roleUser'] === 'admin') {
    $sql = "UPDATE sae203_tickets SET descriptionTicket = :description WHERE idTicket = :id";
  } else {
    $sql = "UPDATE sae203_tickets SET descriptionTicket = CONCAT(descriptionTicket, :description) WHERE idTicket = :id";
  }

  // we prepare the array to execute the sql command
  $prepareArray = array(
    'description' => $description,
    'id' => $id
  );

  try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($prepareArray);
  } catch (PDOException $e) {
    echo $e->getMessage();
    header('Location: /sae203/tickets/index.php?error=sqlError');
    die();
  }
}


// we redirect to the ticket page with a success message in the url parameters

header('Location: /sae203/tickets/ticket.php?id=' . $id . '&success=ticketModified');

?>