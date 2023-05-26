<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Se connecter</title>
  <?php include_once("../components/libraries.php"); ?>

</head>

<body>

  <?php include_once("../components/header.php"); ?>

  <main class="flex flex-col justify-center items-center h-96 w-screen">
    <h1 class="text-4xl font-bold mb-10">Se connecter</h1>
    <form action="../controllers/login.php" method="POST" class="flex flex-col justify-center items-center">
      <input type="text" name="email" placeholder="Email" class="border-2 border-gray-300 rounded-md p-2 mb-5" required
        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
      <input type="password" name="password" placeholder="Mot de passe"
        class="border-2 border-gray-300 rounded-md p-2 mb-5" required>
      <button type="submit" class="bg-indigo-900 text-white font-bold p-2 rounded-md">Se connecter</button>
    </form>
  </main>

</body>

</html>