<?php

if (!isset($_POST['email'], $_POST['password'])) {
  header('Location: ../account/login.php?error=wrongForm');
  die();
}

@include('../database/connection.php');

$mail = $_POST['email'];
$password = $_POST['password'];

$sql = 'SELECT passwordUser FROM sae203_users WHERE mailUser = :mail';

$stmt = $pdo->prepare($sql);
$stmt->execute(array('mail' => $mail));

$result = $stmt->fetch(PDO::FETCH_ASSOC);


if (sha1($password) === $result['passwordUser']) {

  session_start();

  $sql = 'SELECT idUser, firstnameUser, lastnameUser, mailUser, imageUser, roleUser FROM sae203_users WHERE mailUser = :mail';

  $stmt = $pdo->prepare($sql);
  $stmt->execute(array('mail' => htmlentities($mail)));

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $_SESSION['user'] = $result;

  header('Location: ../sae203.php');

  die();

} else {

  header('Location: ../account/login.php?error=wrongCredentials');
  die();

}



?>