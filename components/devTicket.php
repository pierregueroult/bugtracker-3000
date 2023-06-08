<?php
// this component is used to display a ticket for a dev
// a ticket value has to be declared before including this component
// the ticket value is an array containing the ticket data from the database
// the ticket value is an associative array with the following keys:
// idTicket, titleTicket, descriptionTicket, tagTicket, statusTicket, createdAt, closedAt, assignedAt, scaleTicket, userId, devId, firstnameUser, lastnameUser, mailUser, roleUser
?>
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
    <?= $ticket['scaleTicket'] == 0 ? "Non défini" : $ticket['scaleTicket'] . "/5"; ?>
  </td>
  <td class=" text-lg text-indigo-900 px-4">
    <?= $ticket['tagTicket'] ?>
  </td>

</tr>