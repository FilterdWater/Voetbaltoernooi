<?php
require_once 'php/components.php';
require_once 'php/db.php';
require_once 'php/functions.php';
redirectToLoginIfNotLoggedIn();

$QueryGetAllmatches = 'SELECT * FROM wedstrijd';
$stmtmatches = $pdo->query($QueryGetAllmatches);
?>
<!doctype html>
<?php htmlhead('matches'); ?>
<html lang="en">
  <body>
    <?php htmlheader(); ?>
    <div class="mt-4 flex justify-center px-8 py-4">
      <a href="matchcreation.php" class="rounded-md bg-orange-400 px-4 py-2 text-white transition-colors duration-200 hover:bg-orange-500">Create a match</a>
    </div>

    <div class="grid grid-cols-1 gap-8 p-8 lg:grid-cols-2">
    <?php while ($wedstrijd = $stmtmatches->fetch(PDO::FETCH_ASSOC)): ?>
        <?php
        $teamAId = $wedstrijd['team_a_id'];
        $teamBId = $wedstrijd['team_b_id'];

        $queryGetTeamA = 'SELECT * FROM team WHERE id = :teamAId';
        $queryGetTeamB = 'SELECT * FROM team WHERE id = :teamBId';

        $stmtTeamA = $pdo->prepare($queryGetTeamA);
        $stmtTeamB = $pdo->prepare($queryGetTeamB);

        $stmtTeamA->bindParam(':teamAId', $teamAId, PDO::PARAM_INT);
        $stmtTeamB->bindParam(':teamBId', $teamBId, PDO::PARAM_INT);

        $stmtTeamA->execute();
        $stmtTeamB->execute();

        $teamA = $stmtTeamA->fetch(PDO::FETCH_ASSOC);
        $teamB = $stmtTeamB->fetch(PDO::FETCH_ASSOC);

        if ($teamA && is_array($teamB)) { ?>
            <div class="bg-white p-4 shadow-md rounded-md text-center">
                <p class="text-lg font-semibold mb-2"><?= $teamA['name'] . ' - ' . $teamB['name'] ?></p>
                <p class="text-lg font-semibold mb-2"><?= $wedstrijd['team_a_id'] . ' - ' . $wedstrijd['team_b_id'] ?></p>
                <p>Datum: <?= $wedstrijd['datum'] ?></p>
            </div>
        <?php } else {// Handle the case where the fetch operation failed (e.g., no results found)
          echo '<div class="bg-white p-4 shadow-md rounded-md text-center">No data available</div>';}
        endwhile; ?>
</div>
  </body>

  <script src="js/functions.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', hamburger());
  </script>
</html>
