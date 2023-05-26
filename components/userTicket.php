<tr class="w-full">
  <td class="text-xl font-bold text-black hover:text-indigo-700 p-4">
    <a href="./ticket.php?id=<?= $ticket['idTicket'] ?>"><?= $ticket['titleTicket'] ?></a>
  </td>
  <td class="text-lg text-indigo-900 px-4
  max-w-xl
    whitespace-nowrap
    overflow-hidden
    overflow-ellipsis">

    <?= $ticket['descriptionTicket'] ?>
  </td>
  <td class="text-lg text-indigo-900">
    Crée le :
    <?= $ticket['createdAt'] ?>
  </td>
  <td class="text-lg text-indigo-900 px-4">
    <?php

    if ($ticket['statusTicket'] === 'closed') {
      echo "Fermé le : " . $ticket['closedAt'];
    }
    if ($ticket['statusTicket'] === 'assigned') {
      echo "Attribué le : " . $ticket['assignedAt'];
    }

    ?>
  </td>
  <td class="text-lg text-indigo-900 px-4">
    <?php

    if ($ticket['statusTicket'] == 'waiting') {
      echo "En attente";
    } else if ($ticket['statusTicket'] == 'assigned') {
      echo "En cours";
    } else {
      echo "Fermé";
    }

    ?>
  </td>
  <td class=" text-lg text-indigo-900 px-4">
    <?= $ticket['tagTicket'] ?>
  </td>

</tr>