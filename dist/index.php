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
</body>
<script src="js/functions.js"></script>
<script>document.addEventListener('DOMContentLoaded', hamburger());</script>
</html>