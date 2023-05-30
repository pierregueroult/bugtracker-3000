<?php

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: ../account/login.php?error=notConnected');
  die();
}

if (!isset($_GET['id'])) {
  header('Location: ../tickets/index.php?error=notFound');
  die();
}

$role = $_SESSION['user']['roleUser'];

include('../database/connection.php');

$sql = "SELECT * FROM sae203_tickets WHERE idTicket = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute(array('id' => $_GET['id']));
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
  header('Location: ../tickets/index.php?error=notFound');
  die();
}

if ($result['devId'] != null) {
  $sql = "SELECT * FROM sae203_users WHERE idUser = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array('id' => $result['devId']));
  $resultUser = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voir un ticket</title>
  <?php include('../components/libraries.php'); ?>
</head>

<body>
  <?php include('../components/header.php'); ?>
  <main>
    <?php
    if ($role == "user" || $result['statusTicket'] == "closed") {
      ?>
      <section class="flex flex-col gap-8 min-w-fit justify-center items-center mt-32">
        <h1 class="text-3xl font-bold text-indigo-900 text-center">
          <?= $result['titleTicket'] ?>
        </h1>
        <p class="text-xl text-black w-1/2">
          <?= $result['descriptionTicket'] ?>
        </p>
        <div class="w-1/2 flex flex-row justify-center items-center rounded-lg p-4
          <?= $result['statusTicket'] === 'waiting' ? "bg-red-700" : "" ?>
          <?= $result['statusTicket'] === 'assigned' ? "bg-green-700" : "" ?>
          <?= $result['statusTicket'] === 'closed' ? "bg-gray-700" : "" ?>
          ">
          <p class="text-xl text-white font-bold">
            <?php
            if ($result['statusTicket'] == "waiting") {
              echo "Votre ticket est en attente de traitement";
            } else if ($result['statusTicket'] == "assigned") {
              echo "Votre ticket est en cours de traitement";
            } else if ($result['statusTicket'] == "closed") {
              echo "Votre ticket a été traité. Il est à présent fermé.";
            }

            ?>
          </p>
        </div>
        <?php if (isset($resultUser)) { ?>
          <div class="w-1/2 flex flex-row justify-between items-center bg-indigo-900 rounded-lg p-4">
            <p class="text-xl text-white w-1/2 text-left">
              Attribué à :
              <?= $resultUser['firstnameUser'] ?>
              <?= $resultUser['lastnameUser'] ?> le
              <?= $result['assignedAt'] ?>
            </p>
            <p class="text-xl text-white w-1/2 text-right">
              Crée le
              <?= $result['createdAt'] ?>
            </p>

          </div>
        <?php } ?>
        <a href="./"
          class="bg-indigo-900 text-white rounded-lg p-4 hover:bg-indigo-700 transition-all duration-200 text-xl mb-32">
          Retourner à la liste des tickets
        </a>
      </section>

    <?php } else if ($role == "admin") { ?>
        <section>
          <form action="../controllers/modifyTicket.php" class="flex flex-col gap-8 justify-center items-center mt-32"
            method="POST">
            <input type="text"
              class="text-3xl font-bold text-indigo-900 text-center w-1/2 border-dashed border-2 border-gray-400"
              name="title" id="title" value="<?= $result['titleTicket'] ?>" required />
            <input type="hidden" required name="id" id="id" value="<?= $result['idTicket'] ?>" class="hidden" />
            <textarea class="text-xl text-black w-1/2 resize-none border-dashed border-2 border-gray-400" rows="10"
              name="description" id="description" cols="80" required spellcheck="true"
              maxlength="500"><?= $result['descriptionTicket'] ?></textarea>
          <?php if ($result['statusTicket'] == "waiting") {
            $sql = "SELECT idUser, firstnameUser, lastnameUser FROM sae203_users WHERE roleUser = 'dev';";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $resultsDev = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $scale = [1, 2, 3, 4, 5];

            ?>
              <div
                class="w-1/2 flex flex-row justify-center items-center rounded-lg p-4 border-dashed border-2 border-gray-400 gap-8">
                <select name="devId" id="devId" class="border-dashed border-2 border-gray-400 rounded-lg p-4 text-xl">
                  <option value="none" selected>Choisir un développeur
                  </option>
                <?php foreach ($resultsDev as $resultDev) { ?>
                    <option value="<?= $result['userId'] ?>">
                    <?= $resultDev['firstnameUser'] ?>
                    <?= $resultDev['lastnameUser'] ?>
                    </option>
                <?php } ?>
                </select>
                <select name="scale" id="scale" class="border-dashed border-2 border-gray-400 rounded-lg p-4 text-xl">
                  <option value="none" selected>Choisir une priorité
                  </option>
                <?php foreach ($scale as $value) { ?>
                    <option value="<?= $value ?>">
                    <?= $value ?>
                    </option>
                <?php } ?>
                </select>
              </div>
          <?php } ?>
            <div class="w-1/2 flex flex-row justify-center items-center rounded-lg p-4 
          <?= $result['statusTicket'] === 'waiting' ? "bg-red-700" : "" ?>
          <?= $result['statusTicket'] === 'assigned' ? "bg-green-700" : "" ?>
          <?= $result['statusTicket'] === 'closed' ? "bg-gray-700" : "" ?>">
              <p class="text-xl text-white font-bold">
                <?php
                if ($result['statusTicket'] == "waiting") {
                  echo "Ce ticket est en attente de traitement";
                } else if ($result['statusTicket'] == "assigned") {
                  echo "Ce ticket est en cours de traitement";
                } else if ($result['statusTicket'] == "closed") {
                  echo "Ce ticket a été traité. Il est à présent fermé.";
                }

                ?>
              </p>
            </div>
            <div class="w-1/2 flex flex-row justify-between items-center">
              <a href="./"
                class="bg-indigo-900 text-white rounded-lg p-4 hover:bg-indigo-700 transition-all duration-200 text-xl mb-4">
                Retourner à la liste des tickets
              </a>
              <button type="submit"
                class="bg-indigo-900 text-white rounded-lg p-4 hover:bg-indigo-700 transition-all duration-200 text-xl mb-4">
                Mettre à jour le ticket
              </button>
            </div>
          </form>
          <div class="flex justify-end items-center w-1/2 relative left-1/4">
            <form action="../controllers/closeTicket" method="POST">
              <input type="hidden" name="id" id="id" value="<?= $result['idTicket'] ?>" class="hidden" />
              <button type="submit"
                class="bg-indigo-900 text-white rounded-lg p-4 hover:bg-indigo-700 transition-all duration-200 text-xl mb-32">
                Fermer le ticket
              </button>
            </form>
          </div>
        </section>

    <?php } else if ($role === "dev") { ?>
          <section>
            <form action="../controllers/modifyTicket.php" class="flex flex-col gap-8 justify-center items-center mt-32"
              method="POST">
              <input type="text"
                class="text-3xl font-bold text-indigo-900 text-center w-1/2 border-dashed border-2 border-gray-400"
                name="title" id="title" value="<?= $result['titleTicket'] ?>" required />
              <input type="hidden" required name="id" id="id" value="<?= $result['idTicket'] ?>" class="hidden" />
              <textarea class="text-xl text-black w-1/2 resize-none border-dashed border-2 border-gray-400" rows="10"
                name="description" id="description" cols="80" required spellcheck="true"
                maxlength="500"><?= $result['descriptionTicket'] ?></textarea>
              <div class="w-1/2 flex flex-row justify-center items-center rounded-lg p-4 
          <?= $result['statusTicket'] === 'waiting' ? "bg-red-700" : "" ?>
          <?= $result['statusTicket'] === 'assigned' ? "bg-green-700" : "" ?>
          <?= $result['statusTicket'] === 'closed' ? "bg-gray-700" : "" ?>">
                <p class="text-xl text-white font-bold">
                <?php
                if ($result['statusTicket'] == "waiting") {
                  echo "Ce ticket est en attente de traitement";
                } else if ($result['statusTicket'] == "assigned") {
                  echo "Ce ticket est en cours de traitement";
                } else if ($result['statusTicket'] == "closed") {
                  echo "Ce ticket a été traité. Il est à présent fermé.";
                }
                ?>
                </p>
              </div>
              <div class="w-1/2 flex flex-row justify-between items-center">
                <a href="./"
                  class="bg-indigo-900 text-white rounded-lg p-4 hover:bg-indigo-700 transition-all duration-200 text-xl mb-4">
                  Retourner à la liste des tickets
                </a>
                <button type="submit"
                  class="bg-indigo-900 text-white rounded-lg p-4 hover:bg-indigo-700 transition-all duration-200 text-xl mb-4">
                  Mettre à jour le ticket
                </button>
              </div>
            </form>
            <div class="flex justify-end items-center w-1/2 relative left-1/4">
              <form action="../controllers/closeTicket" method="POST">
                <input type="hidden" name="id" id="id" value="<?= $result['idTicket'] ?>" class="hidden" />
                <button type="submit"
                  class="bg-indigo-900 text-white rounded-lg p-4 hover:bg-indigo-700 transition-all duration-200 text-xl mb-32">
                  Fermer le ticket
                </button>
              </form>
            </div>
          </section>
    <?php } ?>
  </main>
  <?php include('../components/footer.php'); ?>
</body>

</html>