<?php

if (isset($_SESSION['user'])) {
  header('Location: ../account/register.php?error=alreadyConnected');
  die();
}

if (
  !isset(
  $_POST['firstname'],
  $_POST['lastname'],
  $_POST['mail'],
  $_POST['password'],
  $_POST['passwordConf'],
)
) {
  header('Location: ../account/register.php?error=missingData');
  die();
}

if (
  empty(
  $_POST['firstname'] ||
  $_POST['lastname'] ||
  $_POST['mail'] ||
  $_POST['password'] ||
  $_POST['passwordConf']
)
) {
  header('Location: ../sae203.php?error=emptyData');
  die();
}

if ($_POST['password'] !== $_POST['passwordConf']) {
  header('Location: ../account/register.php?error=passwordsDontMatch');
  die();
}

if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
  header('Location: ../account/register.php?error=invalidMail');
  die();
}

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$mail = $_POST['mail'];
$password = $_POST['password'];

$shaPassword = sha1($password);


@include "../database/connection.php";

if (strlen($_FILES['image']['name']) > 0 && $_FILES['image']['error'] === 0) {

  $name = $_FILES['image']['name'];

  $explodedExtension = explode('.', $name);
  $fileExtention = strtolower(end($explodedExtension));

  $newFileName = uniqid('', true) . '.' . $fileExtention;

  move_uploaded_file($_FILES['image']['tmp_name'], '../src/images/pfp/' . $newFileName);

  $sql = "INSERT INTO sae203_users (firstnameUser, lastnameUser, mailUser, passwordUser, imageUser) VALUES (:firstname, :lastname, :mail, :passwordUser, :imageUser)";

  $stmt = $pdo->prepare($sql);
  $stmt->execute(
    array(
      'firstname' => htmlentities($firstname),
      'lastname' => htmlentities($lastname),
      'mail' => htmlentities($mail),
      'passwordUser' => htmlentities($shaPassword),
      'imageUser' => "/sae203/src/images/pfp/$newFileName"
    )
  );

  // unlink($_FILES['image']['name']);
  // unlink($_FILES['image']['tmp_name']);

  header('Location: ../account/login.php?success=accountCreated');

  die();

} else {
  $sql = "INSERT INTO sae203_users (firstnameUser, lastnameUser, mailUser, passwordUser) VALUES (:firstname, :lastname, :mail, :passwordUser)";

  $stmt = $pdo->prepare($sql);
  $stmt->execute(
    array(
      'firstname' => htmlentities($firstname),
      'lastname' => htmlentities($lastname),
      'mail' => htmlentities($mail),
      'passwordUser' => $shaPassword
    )
  );

  header('Location: ../account/login.php?success=accountCreated');

  die();
}











var_dump($_POST);
echo "<br>";
var_dump($_FILES['image']);

?>