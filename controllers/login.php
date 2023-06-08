<?php

// this file is used to login a user
// taking the email and the password as parameters


// if the parameters are not set, redirect to login page
if (!isset($_POST['email'], $_POST['password'])) {
  header('Location: ../account/login.php?error=wrongForm');
  die();
}

// we initialize the database connection
include('../database/connection.php');

// we get the informations from the form
$mail = $_POST['email'];
$password = $_POST['password'];

// sql command to get the password from the database
$sql = 'SELECT passwordUser FROM sae203_users WHERE mailUser = :mail';

// we execute the sql command
$stmt = $pdo->prepare($sql);
$stmt->execute(array('mail' => $mail));
$result = $stmt->fetch(PDO::FETCH_ASSOC);


// test if the password is not found or if the password is wrong
if (sha1($password) === $result['passwordUser']) {

  session_start();

  // sql command to get the user informations
  $sql = 'SELECT idUser, firstnameUser, lastnameUser, mailUser, imageUser, roleUser FROM sae203_users WHERE mailUser = :mail';

  // we execute the sql command
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array('mail' => htmlentities($mail)));

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  // we store the user informations in the session
  $_SESSION['user'] = $result;

  // we redirect to the home page
  header('Location: ../sae203.php');

  die();

} else {

  // if the password is wrong, redirect to login page
  header('Location: ../account/login.php?error=wrongCredentials');
  die();

}



?>