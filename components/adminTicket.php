<tr class="w-full">
  <td class="text-xl font-bold text-indigo-900 hover:text-indigo-700 p-4">
    <a href="./ticket.php?id=<?= $ticket['idTicket'] ?>"><?= $ticket['titleTicket'] ?></a>
  </td>
  <td class="text-lg text-indigo-900 px-4 max-w-sm whitespace-nowrap overflow-hidden overflow-ellipsis">
    <?= $ticket['descriptionTicket'] ?>
  </td>
  <td class="text-lg text-indigo px-4
  ">
    Crée le : <?= $ticket['createdAt']; ?>
  </td>
  <td class="text-lg text-indigo-900 px-4">
    <?php

    if ($ticket['statusTicket'] === 'closed') {
      echo "Fermé le : " . $ticket['closedAt'] . " par " . $ticket['firstnameUser'] . " " . $ticket['lastnameUser'] . " (" . $ticket['mailUser'] . ")";
    }
    if ($ticket['statusTicket'] === 'assigned') {
      echo "Attribué le : " . $ticket['assignedAt'] . " à " . $ticket['firstnameUser'] . " " . $ticket['lastnameUser'] . " (" . $ticket['mailUser'] . ")";
    }

    ?>
  </td>
  <td class="text-lg text-indigo-900 px-4">
    <?php

    if ($ticket['statusTicket'] == 'assigned') {
      echo "En cours - Priorité : " . ($ticket['scaleTicket'] == 0 ? "Non défini" : $ticket['scaleTicket'] . "/5");
    } else if ($ticket['statusTicket'] == 'closed') {
      echo "Fermé";
    }

    if ($ticket['statusTicket'] == 'waiting') {

      $sql = "SELECT idUser, firstnameUser, lastnameUser FROM sae203_users WHERE roleUser = 'dev'";

      $stmt = $pdo->prepare($sql);
      $stmt->execute();

      $devs = $stmt->fetchAll();

      ?>

      <form action="/sae203/controllers/assignTicket.php" method="POST">
        <select name="dev" id="dev">
          <option value="none" selected>
            Attribuer le ticket
          </option>
          <?php

          foreach ($devs as $dev) {
            ?>
            <option value="<?= $dev['idUser'] ?>">
              <?= $dev['firstnameUser'] . " " . $dev['lastnameUser'] ?>
            </option>
            <?php
          }

          ?>
        </select>
        <select name="scale" id="scale">
          <option value="none" selected>
            Priorité
          </option>

          <?php
          $scales = [1, 2, 3, 4, 5];

          foreach ($scales as $scale) {
            ?>
            <option value="<?= $scale ?>">
              <?= $scale ?>
            </option>
            <?php
          }
          ?>
        </select>
        <input type="hidden" name="ticketId" value="<?= $ticket['idTicket'] ?>" class="hidden">
        <button type="submit"
          class="bg-indigo-900 text-white rounded-md p-3 hover:bg-indigo-700 transition duration-300 mt-4">
          Mettre à jour
        </button>
      </form>

      <?php
    }

    ?>
  </td>
  <td class="text-lg text-indigo-900 px-4">
    <?= $ticket['tagTicket'] ?>
  </td>
</tr>