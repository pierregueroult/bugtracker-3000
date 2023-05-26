<?php

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: ./account/login.php?error=notConnected');
  die();
}

session_destroy();

header('Location: ../sae203.php');

?>