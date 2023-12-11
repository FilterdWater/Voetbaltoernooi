<?php
$pageName = 'login';
require_once 'php/functions.php';
redirectToHomeIfLoggedIn();
require_once 'php/db.php';
require_once 'php/classes/account.php';
require_once 'php/components.php';

//als de gebruiker is ingelogd komt er een button in de navbar waarmee je kan uitloggen

$account = new Account($pdo);
if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $pw = $_POST['password'];
  $success = $account->login($email, $pw);
  if ($success) {
    $userData = $account->getUser($email);
    $_SESSION['logged_in'] = true;
    $_SESSION['id'] = $userData['id'];
    $_SESSION['Gebruiker'] = $userData['first_name'] . ' ' . $userData['last_name'];
    header('location: index.php');
  }
}
?>
<!doctype html>
<html lang="en">
  <?php htmlhead($pageName); ?>
  <body>
    <section class="bg-white">
      <div class="lg:grid lg:min-h-screen lg:grid-cols-12">
        <section class="relative flex h-32 items-end bg-gray-900 lg:col-span-5 lg:h-full xl:col-span-6">
          <img alt="Night" src=" images/jpeg/pexels-photo-102448.jpeg" class="absolute inset-0 h-full w-full object-cover opacity-80" />
          <div class="hidden lg:relative lg:block lg:p-12">
            <a class="block w-fit rounded-lg bg-zinc-700/50 p-2 text-white shadow-lg backdrop-blur-sm" href="index.php">
              <span class="sr-only">Home</span>
              <img src="images/svg/knvb.svg" alt="knvb-logo" class="h-20 w-auto" />
            </a>
            <h2 class="mt-6 rounded-lg bg-zinc-700/50 p-2 text-2xl font-bold text-white backdrop-blur-sm sm:text-3xl md:text-4xl">Welcome to KNVB</h2>
          </div>
        </section>

        <main class="flex items-center justify-center px-8 py-8 sm:px-12 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-6">
          <div class="max-w-xl lg:max-w-3xl">
            <div class="relative -mt-16 block ">
              <a class="inline-flex h-16 w-16 items-center justify-center lg:hidden rounded-full bg-white text-blue-600 sm:h-20 sm:w-20" href="index.php">
                <span class="sr-only">Home</span>
                <img src="images/svg/knvb.svg" alt="knvb-logo" class="h-14 sm:h-16" />
              </a>
              <h1 class="mt-2 text-2xl font-bold text-orange-400 sm:text-3xl md:text-4xl">Login</h1>
            </div>

            <form method="POST" class="mt-8 grid grid-cols-6 gap-6">
              <div class="col-span-6">
                <label for="Email" class="block text-sm font-medium text-gray-700"> Email </label>
                <input type="email" id="Email" name="email" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" />
                <?php echo $account->getError('email'); ?>
              </div>

              <div class="col-span-6">
                <label for="Password" class="block text-sm font-medium text-gray-700"> Password </label>
                <input type="password" id="Password" name="password" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" />
                <?php echo $account->getError('password'); ?>
              </div>

              <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
                <button type="submit" name="submit" class="inline-block shrink-0 rounded-md border border-orange-400 bg-orange-400 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-orange-600 focus:outline-none focus:ring active:text-orange-500">Login</button>
                <p class="mt-4 text-sm text-gray-500 sm:mt-0">
                  dont have an account yet?
                  <a href="register.php" class="text-gray-700 underline">Register</a>.
                </p>
              </div>
            </form>
          </div>
        </main>
      </div>
    </section>
  </body>
</html>
