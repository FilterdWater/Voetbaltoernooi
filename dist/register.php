<?php
$pageName = 'login';
require_once 'php/db.php';
require_once 'php/classes/account.php';
require_once 'php/components.php';
//require_once 'php/components.php';

$account = new Account($pdo);

if (isset($_POST['submitRegister'])) {
  $voornaam = $_POST['first_name'];
  $achternaam = $_POST['last_name'];
  $email = $_POST['email'];
  $pw = $_POST['password'];
  $pw2 = $_POST['password_confirmation'];
  $admin = isset($_POST['admin_select']) ? 1 : 0;
  $success = $account->register($voornaam, $achternaam, $pw, $pw2, $email, $admin);
  if ($success) {
    //$_SESSION['Gebruiker'] = $voornaam + ' ' + $achternaam;
    header('location: login.php');
  }
}
?>

<!doctype html>
<html lang="en">
  <?php htmlhead(); ?>
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
              <a class="inline-flex h-16 w-16 items-center justify-center lg:hidden rounded-full bg-white text-blue-600 sm:h-20 sm:w-20" href="/">
                <span class="sr-only">Home</span>
                <img src="images/svg/knvb.svg" alt="knvb-logo" class="h-14 sm:h-16" />
              </a>
              <h1 class="mt-2 text-2xl font-bold text-orange-400 sm:text-3xl md:text-4xl">Welcome to KNVB</h1>
              <p class="mt-4 leading-relaxed text-gray-500">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eligendi nam dolorum aliquam, quibusdam aperiam voluptatum.</p>
            </div>

            <form method="POST" class="mt-8 grid grid-cols-6 gap-6">
              <div class="col-span-6 sm:col-span-3">
                <label for="FirstName" class="block text-sm font-medium text-gray-700"> First Name </label>
                <input type="text" id="FirstName" name="first_name" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" />
					      <?php echo $account->getError('firstName'); ?>
              </div>

              <div class="col-span-6 sm:col-span-3">
                <label for="LastName" class="block text-sm font-medium text-gray-700"> Last Name </label>
                <input type="text" id="LastName" name="last_name" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" />
					 <?php echo $account->getError('firstName'); ?>
              </div>

              <div class="col-span-6">
                <label for="Email" class="block text-sm font-medium text-gray-700"> Email </label>
                <input type="email" id="Email" name="email" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" />
					 <?php echo $account->getError('email'); ?>
              </div>

              <div class="col-span-6 sm:col-span-3">
                <label for="Password" class="block text-sm font-medium text-gray-700"> Password </label>
                <input type="password" id="Password" name="password" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" />
					 <?php echo $account->getError('password'); ?>
              </div>

              <div class="col-span-6 sm:col-span-3">
                <label for="PasswordConfirmation" class="block text-sm font-medium text-gray-700"> Password Confirmation </label>
                <input type="password" id="PasswordConfirmation" name="password_confirmation" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" />
					 <?php echo $account->getError('password2'); ?> 
					 <!--nog iets mee doen-->
              </div>

              <div class="col-span-6">
                <label for="MarketingAccept" class="flex gap-4">
                  <input type="checkbox" id="AdminSelect" name="admin_select" class="h-5 w-5 rounded-md border-gray-200 bg-white shadow-sm" />
                  <span class="text-sm text-gray-700"> I want to be an Admin. </span>
                </label>
              </div>

              <div class="col-span-6">
                <p class="text-sm text-gray-500">
                  By creating an account, you agree to our
                  <a href="#" class="text-gray-700 underline"> terms and conditions </a>
                  and
                  <a href="#" class="text-gray-700 underline">privacy policy</a>.
                </p>
              </div>

              <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
                <button type="submit" name="submitRegister" class="inline-block shrink-0 rounded-md border border-orange-400 bg-orange-400 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-orange-600 focus:outline-none focus:ring active:text-orange-500">Create an account</button>
                <p class="mt-4 text-sm text-gray-500 sm:mt-0">
                  Already have an account?
                  <a href="login.php" class="text-gray-700 underline">Log in</a>.
                </p>
              </div>
            </form>
          </div>
        </main>
      </div>
    </section>
  </body>
</html>
