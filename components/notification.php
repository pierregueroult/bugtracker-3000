<?php
// this component is used in every page to display notifications

// we check if there is an error or a success in the url

if (isset($_GET['error']) || isset($_GET['success'])) {

  // we create the lists of errors and success messages
  $errorList = array(
    'wrongCredentials' => 'Identifiants incorrects',
    'notConnected' => 'Vous devez être connecté pour accéder à cette page',
    'notFound' => 'Page introuvable',
    'alreadyExists' => 'Ce compte existe déjà',
    'notSamePassword' => 'Les mots de passe ne sont pas identiques',
    'missingData' => 'Veuillez remplir tous les champs',
    'emptyData' => 'Veuillez remplir tous les champs',
    'invalidMail' => 'Veuillez entrer une adresse mail valide',
    'alreadyConnected' => 'Vous êtes déjà connecté',
    'wrongForm' => 'Formulaire incorrect',
    'notLogged' => 'Vous devez être connecté pour accéder à cette page',
    'notAllowed' => 'Vous n\'avez pas les droits pour accéder à cette page',
    "mailAlreadyUsed" => "Cette adresse mail est déjà utilisée",
    "sqlError" => "Erreur SQL"
  );

  $sucessList = array(
    'accountCreated' => 'Votre compte a bien été créé',
    'ticketCreated' => 'Votre ticket a bien été créé',
    'closed' => 'Le ticket a bien été fermé',
    'ticketAssigned' => 'Le ticket a bien été assigné',
    'ticketModified' => 'Le ticket a bien été modifié',
  );


  // we adapt the notification to the error or the success (color and message)

  ?>
  <aside
    class="fixed w-1/5 h-24 flex flex-row justify-center message items-center bottom-3.5 right-3.5 <?= isset($_GET['error']) ? "bg-red-500" : "bg-green-500" ?>">
    <?php if (isset($_GET['error'])) { ?>
      <p class="text-white text-center text-xl font-bold pt-2 w-3/4">
        Erreur :
        <?= $errorList[$_GET['error']] ?>
      </p>
    <?php } else { ?>
      <p class="text-white text-center text-xl font-bold pt-2 w-3/4">
        Succés :
        <?= $sucessList[$_GET['success']] ?>
      </p>
    <?php } ?>
  </aside>
<?php } ?>