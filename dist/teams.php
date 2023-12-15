<?php
require_once 'php/components.php';
require_once 'php/db.php';
require_once 'php/functions.php';
redirectToLoginIfNotLoggedIn();

$QueryGetAllTeams = 'SELECT * FROM team';
$stmtTeams = $pdo->query($QueryGetAllTeams);
?>
<!doctype html>
<?php htmlhead('teams'); ?>
<html lang="en">
  <body>
    <?php htmlheader(); ?>
    <div class="mt-4 flex justify-center px-8 py-4">
      <a href="teamcreation.php" class="rounded-md bg-orange-400 px-4 py-2 text-white transition-colors duration-200 hover:bg-orange-500">Maak je eigen team</a>
    </div>

    <div class="grid grid-cols-1 gap-8 p-8 lg:grid-cols-2">
      <?php
      while ($row = $stmtTeams->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='bg-white border border-gray-300 p-6 rounded-md text-center'>";
        echo "<a class='font-bold text-2xl break-all hover:text-orange-400 transition-colors duration-200' href='teamdetails.php?id=" . $row['id'] . "'>" . $row['name'] . '</a>'; // Retrieve players for the current team
        $teamId = $row['id'];
        $GetTeamPlayers = "SELECT user.first_name, user.last_name 
                          FROM user
                          JOIN user_has_team ON user.id = user_has_team.user_id
                          WHERE user_has_team.team_id = $teamId";
        $stmtPlayers = $pdo->query($GetTeamPlayers);
        echo "
        <table class='w-full text-left mt-8'>
            <tr class='border-b text-center'>
                <th class='py-2'>First name</th>
                <th class='py-2'>Last name</th>
            </tr>";
        while ($player = $stmtPlayers->fetch(PDO::FETCH_ASSOC)) {
          echo "<tr class='border-b text-center'>
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
  <script>
    document.addEventListener('DOMContentLoaded', hamburger());
  </script>
</html>
