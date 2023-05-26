<?php

session_start();

if (isset($_SESSION['user'])) {
  header('Location: ../sae203.php?error=alreadyConnected');
  die();
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Créer un compte</title>
  <?php include_once("../components/libraries.php"); ?>
</head>

<body>
  <?php include_once("../components/header.php"); ?>

  <main class="flex flex-col justify-center items-center h-auto w-screen mt-16">
    <h1 class="text-4xl font-bold mb-10">Créer un compte</h1>
    <form action="../controllers/register.php" method="POST" class="flex flex-col justify-center items-center"
      enctype="multipart/form-data">
      <p class='flex flex-row justify-between items-center'>
        <label for="firstname">Prénom :</label>
        <input type="text" name="firstname" placeholder="Jean" class="border-2 border-gray-300 rounded-md p-2 mb-5"
          required>
      </p>
      <p class='flex flex-row justify-between items-center'>
        <label for="lastname">
          Nom :
        </label>
        <input type="text" name="lastname" placeholder="Nom" class="border-2 border-gray-300 rounded-md p-2 mb-5"
          required>
      </p>
      <p class='flex flex-row justify-between items-center'>
        <label for="mail">Adresse mail :</label>
        <input type="text" name="mail" placeholder="E-mail" class="border-2 border-gray-300 rounded-md p-2 mb-5"
          required>
      </p>
      <p class='flex flex-row justify-between items-center'>
        <label for="password">
          Mot de passe :
        </label>
        <input type="password" name="password" placeholder="Mot de passe"
          class="border-2 border-gray-300 rounded-md p-2 mb-5" required>
      </p>
      <p class='flex flex-row justify-between items-center'>
        <label for="passwordConf">
          Confirmer le mot de passe :
        </label>
        <input type="password" name="passwordConf" placeholder="Confirmation du mot de passe"
          class="border-2 border-gray-300 rounded-md p-2 mb-5" required>
      </p>
      <p>
        <label for="image">Image de profil (2 MO max) <br />(fonctionnalité expérimentale ):</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
        <input type="file" name="image" placeholder="Image de profil" accept="image/png, image/jpeg"
          class="border-2 border-gray-300 rounded-md p-2 mb-5">
      </p>
      <button type="submit" class="bg-indigo-900 text-white font-bold p-2 rounded-md">Créer un compte</button>
    </form>
  </main>
</body>

</html>