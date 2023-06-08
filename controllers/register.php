<?php

// this file is used to register a user
// taking the firstname, lastname, mail, password and password confirmation as parameters


// if the user is already connected, redirect to home page
if (isset($_SESSION['user'])) {
  header('Location: ../account/register.php?error=alreadyConnected');
  die();
}

// if the parameters are not set, redirect to register page
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

// if the parameters are empty, redirect to register page
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

// if the passwords don't match, redirect to register page
if ($_POST['password'] !== $_POST['passwordConf']) {
  header('Location: ../account/register.php?error=passwordsDontMatch');
  die();
}

// if the mail is not valid, redirect to register page
if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
  header('Location: ../account/register.php?error=invalidMail');
  die();
}

// we take the data from the form
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$mail = $_POST['mail'];
$password = $_POST['password'];
// we hash the password
$shaPassword = sha1($password);

// we initialize the database connection
include "../database/connection.php";

// we check if their an image file in the form
if (strlen($_FILES['image']['name']) > 0 && $_FILES['image']['error'] === 0) {

  // if yes then we take the image name
  $name = $_FILES['image']['name'];

  // we take the extension of the image
  $explodedExtension = explode('.', $name);
  $fileExtention = strtolower(end($explodedExtension));

  // we write a new name for the image with a unique id
  $newFileName = uniqid('', true) . '.' . $fileExtention;

  // we write the sql command to insert the user
  $sql = "INSERT INTO sae203_users (firstnameUser, lastnameUser, mailUser, passwordUser, imageUser) VALUES (:firstname, :lastname, :mail, :passwordUser, :imageUser)";


  try {
    // we execute the sql command
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
  } catch (PDOException $e) {
    // if the mail is already used, redirect to register page
    header('Location: ../account/register.php?error=mailAlreadyUsed');
    die();
  }

  // we move the image to the pfp folder
  move_uploaded_file($_FILES['image']['tmp_name'], '../src/images/pfp/' . $newFileName);

  // we redirect to login page
  header('Location: ../account/login.php?success=accountCreated');

  die();

} else {
  // if their is no image in the form, we write the sql command to insert the user without the image
  $sql = "INSERT INTO sae203_users (firstnameUser, lastnameUser, mailUser, passwordUser) VALUES (:firstname, :lastname, :mail, :passwordUser)";

  try {
    // we execute the sql command
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
      array(
        'firstname' => htmlentities($firstname),
        'lastname' => htmlentities($lastname),
        'mail' => htmlentities($mail),
        'passwordUser' => $shaPassword
      )
    );
  } catch (PDOException $e) {
    // if the mail is already used, redirect to register page
    header('Location: ../account/register.php?error=mailAlreadyUsed');
    die();
  }

  // if success, we redirect to login page
  header('Location: ../account/login.php?success=accountCreated');

  die();
}











var_dump($_POST);
echo "<br>";
var_dump($_FILES['image']);

?>