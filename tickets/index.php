<?php

session_start();

$tags = ['Bug', 'Amélioration', 'Suggestion', 'Question'];

if (!isset($_SESSION['user'])) {
  header('Location: ../account/login.php?error=notConnected');
  die();
}

$id = $_SESSION['user']['idUser'];
$role = $_SESSION['user']['roleUser'];

include('../database/connection.php');

if ($role === "user") {
  $sql = "SELECT * FROM sae203_tickets WHERE userId = :identifiant";
} else if ($role === "dev") {
  $sql = "SELECT * FROM sae203_tickets WHERE devId = :identifiant && statusTicket != 'closed'";
} else {
  $sql = "SELECT * FROM sae203_tickets LEFT JOIN sae203_users ON sae203_tickets.devId = sae203_users.idUser";
}

if (isset($_GET['tag']) && $_GET['tag'] !== 'Tous') {
  $tag = $_GET['tag'];
  if ($role === "user" || $role === "dev") {
    $sql .= " AND tagTicket = '$tag'";
  } else {
    $sql .= " WHERE tagTicket = '$tag'";
  }
}

if (isset($_GET['sort'])) {
  $keyword = $_GET['sort'] === 'title' ? 'titleTicket' : 'createdAt';
  $sql .= " ORDER BY $keyword ASC";
}

$stmt = $pdo->prepare($sql);

$stmt->execute($role !== "admin" ? array('identifiant' => $id) : array());

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suivre les tickets</title>

  <?php include('../components/libraries.php'); ?>

</head>

<body>

  <?php include('../components/header.php'); ?>

  <main class="flex flex-col content-center items-center w-full" style="min-height: calc(100vh - 18rem)">
    <h1
      class="text-center text-4xl text-indigo-900 font-bold mb-10 text-center border-b-2 border-indigo-900 pb-5 w-3/5 mt-5">
      <?php
      if ($role === "dev") {
        echo "Vos tickets assignés";
      } else if ($role === "user") {
        echo "Mes tickets";
      } else {
        echo "Tous les tickets";
      }
      ?>
    </h1>
    <!-- sorting form -->
    <form class="flex flex-row justify-between items-center p-5 w-4/5" action="" method="get">
      <div
        class=" flex flex-row justify-center items-center border-2 border-dashed border-gray-400 rounded-md p-3 w-4/12 gap-4">
        <label for="sort">Trier par :</label>
        <select name="sort" id="sort">
          <option value="title" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'title') {
            echo 'selected';
          } ?>>Titre</option>

          <option value="date" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'date') {
            echo 'selected';
          } ?>>Date</option>
        </select>
      </div>
      <div
        class=" flex flex-row justify-center items-center border-2 border-dashed border-gray-400 rounded-md p-3 w-6/12 gap-4">
        <label for="order">Filtrer par tag : </label>

        <input type="radio" name="tag" id="Tous" value="Tous">
        <label for="Tous">
          Tous
        </label>
        <?php

        foreach ($tags as $tag) {
          ?>
          <input type="radio" name="tag" id="<?= $tag ?>" value="<?= $tag ?>">
          <label for="<?= $tag ?>">
            <?= $tag ?>
          </label>
          <?php
        }
        ?>
      </div>
      <button type="submit"
        class="bg-indigo-900 text-white rounded-md p-3 w-1/12 hover:bg-indigo-700 transition duration-300">
        Appliquer
      </button>
    </form>
    <section>
      <table class="border-spacing-y-4 border-separate">
        <thead>
          <tr
            class="text-center text-2xl text-indigo-900 font-bold mb-10 text-center border-b-2 border-indigo-900 pb-5 w-3/5 mt-5">
            <th class="text-left px-0.5">
              Titre</th>
            <th class="text-left px-4">Description</th>
            <th class="text-left px-4">Date</th>
            <th class="text-left px-4">Dernière mise à jour</th>
            <th class="text-left px-4">
              <?= $_SESSION['user']['roleUser'] == 'dev' ? "Priorité" : "Status" ?>
            </th>
            <th class="text-left px-4">Tag</th>
          </tr>
        </thead>
        <tbody>
          <?php

          foreach ($result as $ticket) {
            if ($role === "admin") {
              include('../components/adminTicket.php');
            } else if ($role === "dev") {
              include('../components/devTicket.php');
            } else if ($role === "user") {
              include('../components/userTicket.php');
            } else {
              echo "Erreur";
            }
          }
          ?>
        </tbody>
      </table>
    </section>
  </main>

  <?php include('../components/footer.php'); ?>

</body>

</html>