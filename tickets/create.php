<?php

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: ../account/login.php?error=notConnected');
  die();
}

include('../database/connection.php');

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Créer un ticket</title>

  <?php @include('../components/libraries.php') ?>

</head>

<body>

  <?php @include('../components/header.php') ?>

  <main>
    <section class=" flex flex-col justify-center items-center py-20">
      <form action="../controllers/createTicket.php" method="POST" class="flex flex-col justify-center items-center">
        <h1 class="text-4xl text-indigo-900 font-bold mb-10 text-center border-b-2 border-indigo-900 pb-5 w-100">Créer
          un ticket pour reporter un bug</h1>
        <div
          class="mt-5 flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-md p-3 w-full">
          <label for="title" class="block text-xl font-medium text-gray-700">Titre</label>
          <input type="text" name="title" id="title" placeholder="Titre du ticket" required class="w-full" />

        </div>
        <div
          class="mt-5 flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-md p-3 w-full">
          <label for="description" class="block text-xl font-medium text-gray-700">Description</label>
          <textarea name="description" id="description" cols="30" rows="10" placeholder="Description du ticket" required
            class="w-full resize-none"></textarea>
        </div>
        <div
          class="mt-5 flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-md p-3 w-full">

          <label for="tag" class="block text-xl font-medium text-gray-700">Tag pour le ticket</label>
          <select name="tag"
            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-900 focus:border-indigo-900 sm:text-sm">
            <?php
            $tags = ['Bug', 'Amélioration', 'Suggestion', 'Question'];

            foreach ($tags as $tag) {
              ?>
              <option value="<?= $tag ?>"><?= $tag ?></option>
              <?php
            }

            ?>
          </select>
        </div>
        <button
          class="bg-indigo-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-indigo-700 hover:shadow-md transition duration-300 ease-in-out mt-10"
          type="submit">
          Créer le ticket
        </button>
      </form>
    </section>

  </main>

  <?php @include('../components/footer.php') ?>

</body>

</html>