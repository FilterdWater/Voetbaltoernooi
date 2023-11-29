<?php
require_once 'php/header.php';
require_once 'php/functions.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VoetbalToernooi | Teams</title>
    <link rel="stylesheet" href="./output.css" />
  </head>
  <body>

    <?php
    $pdo = connectToDatabase();
    $sql = 'select * FROM team';
    ?>


    <!-- <ul class="grid grid-cols-1 lg:grid-cols-2 gap-12 place-items-center mt-12 p-12">
        <li class="box-border border-8 border-zinc-500 p-4">
            <div class="font-bold text-7xl break-all">
                Jappies
            </div>
        </li>
    </ul> -->
  </body>
  <script src="js/functions.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', hamburger());
  </script>
</html>
