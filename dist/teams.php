<?php
$pageName = 'teams';
require_once 'php/functions.php';
redirectToLoginIfNotLoggedIn();
require_once 'php/components.php';
require_once 'php/functions.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VoetbalToernooi | Teams</title>
    <link rel="stylesheet" href="./style/output.css" />
  </head>
  <?= htmlHeader($pageName) ?>
  <body>

    <?php
    $pdo = connectToDatabase();
    $sql = 'select * FROM team';
    $stmt = $pdo->query($sql);

    echo '<ul class="grid grid-cols-1 lg:grid-cols-2 gap-12 place-items-center mt-12 p-12">';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<li class='box-border border-8 border-zinc-500 p-4'>";
      echo "<a class='font-bold text-7xl break-all' href='teamdetails.php?id=" . $row['id'] . "'>" . $row['name'] . '</a>';
      echo '</li>';
    }
    $pdo = null;
    echo '</ul>';
    ?>



  </body>
<script src="js/functions.js"></script>
<script>document.addEventListener('DOMContentLoaded', hamburger());</script>
</html>
