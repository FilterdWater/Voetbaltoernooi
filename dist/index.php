<?php
$pageName = 'home';
require_once 'php/functions.php';
redirectToLoginIfNotLoggedIn();
require_once 'php/db.php';
require_once 'php/components.php';
?>
<!DOCTYPE html>
<html lang="en">
    <?php htmlhead($pageName); ?>
<body>
    <?php htmlheader(); ?>

    <div class="bg-gradient-to-b from-orange-400 to-white text-white py-16">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-12">Welcome Bij ons Voetbaltoernooi project</h1>
            <a href="projectCredits.php" class="bg-white text-blue-500 px-6 py-3 rounded-full font-semibold transition-all duration-300 hover:bg-blue-500 hover:text-white">Project Credits</a>
        </div>
    </div>


</body>
<script src="js/functions.js"></script>
<script>document.addEventListener('DOMContentLoaded', hamburger());</script>
</html>
