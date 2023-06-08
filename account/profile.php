<?php

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: ../account/login.php?error=notConnected');
  die();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon compte</title>
  <?php include('../components/libraries.php'); ?>
</head>

<body>
  <?php include('../components/header.php'); ?>
  <main class="flex flex-col content-center items-center" style="min-height: calc(100vh - 18rem)">
    <section>
      <h2
        class="text-center text-4xl text-indigo-900 font-bold mb-10 text-center border-b-2 border-indigo-900 pb-5 w-full mt-5">
        Mon compte</h2>
      <div class="flex flex-col justify-center items-center w-full">
        <div class="flex flex-row items-center justify-between w-full">
          <div class="w-1/3">
            <img
              src="<?= $_SESSION['user']['imageUser'] !== null ? $_SESSION['user']['imageUser'] : "../src/images/pfp/default.jpg" ?>"
              alt="avatar" class="rounded-full w-32 h-32 bg-indigo-900">
          </div>
          <div class="w-2/3">
            <p class="text-center text-2xl font-bold">
              <?= $_SESSION['user']['firstnameUser'] . ' ' . $_SESSION['user']['lastnameUser'] ?>
            </p>
            <p class="text-center text-l font-bold text-center">
              <?php

              if ($_SESSION['user']['roleUser'] === 'admin') {
                echo 'Compte Administrateur';
              } else if ($_SESSION['user']['roleUser'] === 'user') {
                echo 'Compte Utilisateur';
              } else if ($_SESSION['user']['roleUser'] === 'dev') {
                echo 'Compte Développeur';
              }

              ?>
            </p>
            <p class="text-center text-l text-indigo-900 font-bold text-center">
              <a href="mailto:<?= $_SESSION['user']['mailUser'] ?>">
                <?= $_SESSION['user']['mailUser'] ?>
              </a>
            </p>
          </div>
        </div>
        <p class="mt-10">
          <a href="../tickets/index.php"
            class="bg-indigo-900 text-white rounded-md p-3 w-1/12 hover:bg-indigo-700 transition duration-300 ml-2">
            Mes tickets </a>
          <?php if ($_SESSION['user']['roleUser'] === 'user') { ?>
            <a href="../tickets/create.php"
              class="bg-indigo-900 text-white rounded-md p-3 w-1/12 hover:bg-indigo-700 transition duration-300 ml-2">
              Créer un ticket
            </a>
          <?php } ?>
          <a href="../account/logout.php"
            class="bg-indigo-900 text-white rounded-md p-3 w-1/12 hover:bg-indigo-700 transition duration-300 ml-2">
            Se déconnecter
          </a>
        </p>
      </div>
    </section>
  </main>
  <?php include('../components/footer.php'); ?>
</body>

</html>