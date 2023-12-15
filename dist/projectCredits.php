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

    <div class="max-w-2xl mx-auto mt-8 bg-gray-100 p-6 rounded-md">
        <p class="text-lg font-semibold mb-4">Project Credits:</p>
        <p class="mb-2">Project by:
            <a href="https://github.com/FilterdWater" class="text-blue-500 hover:underline">Lars van Holland</a>
            and
            <a href="https://github.com/SanderFrakking" class="text-blue-500 hover:underline">SanderFrakking</a>
        </p>
        <p>Project Link:
            <a href="https://github.com/FilterdWater/Voetbaltoernooi" class="text-blue-500 hover:underline">Voetbaltoernooi on GitHub</a>
        </p>
    </div>

</body>
<script src="js/functions.js"></script>
<script>document.addEventListener('DOMContentLoaded', hamburger());</script>
</html>
