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
$QueryGetAllTeams = 'SELECT * FROM team';
$stmt = $pdo->query($QueryGetAllTeams);
?>

<div class="px-8 py-4 flex justify-center mt-4">
    <a href="teamcreation.php" class="px-4 py-2 bg-orange-400 text-white rounded-md hover:bg-orange-500 transition-colors duration-200">Create your own team</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8  p-8">
    <?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<div class='bg-white border border-gray-300 p-6 rounded-md'>";
      echo "<a class='font-bold text-2xl break-all hover:text-orange-400 transition-colors duration-200' href='teamdetails.php?id=" . $row['id'] . "'>" . $row['name'] . '</a>';

      // Retrieve players for the current team
      $teamId = $row['id'];
      $GetTeamPlayers = "SELECT user.first_name, user.last_name 
                          FROM user
                          JOIN user_has_team ON user.id = user_has_team.user_id
                          WHERE user_has_team.team_id = $teamId";
      $stmtPlayers = $pdo->query($GetTeamPlayers);

      echo "
        <table class='w-full'>
            <tr class='border-b'>
                <th class='py-2'>First name</th>
                <th class='py-2'>Last name</th>
            </tr>";

      while ($player = $stmtPlayers->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr class='border-b'>
                    <td class='py-2'>{$player['first_name']}</td>
                    <td class='py-2'>{$player['last_name']}</td>
                  </tr>";
      }

      echo '</table>';
      echo '</div>';
    }
    $pdo = null;
    ?>
</div>


  </body>
<script src="js/functions.js"></script>
<script>document.addEventListener('DOMContentLoaded', hamburger());</script>
</html>
