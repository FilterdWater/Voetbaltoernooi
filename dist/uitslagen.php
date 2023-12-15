<?php
require_once 'php/components.php';
require_once 'php/db.php';
require_once 'php/functions.php';
redirectToLoginIfNotLoggedIn();

// Use the current date to filter past matches
$currentDate = date('Y-m-d');

$QueryGetPastWedstrijden = 'SELECT * FROM wedstrijd WHERE datum < :currentDate';
$stmtWedstrijden = $pdo->prepare($QueryGetPastWedstrijden);
$stmtWedstrijden->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
$stmtWedstrijden->execute();
?>
<!DOCTYPE html>
<?php htmlhead('Uitslagen'); ?>
<html lang="en">
  <body>
    <?php htmlheader(); ?>

    <?php if (isset($_SESSION['logged_in']) && $_SESSION['admin'] == true) {
      // if User is an admin, display button
      echo '<div class="mt-4 flex justify-center px-8 py-4">
            <a href="wedstrijdCreation.php" class="rounded-md bg-orange-400 px-4 py-2 text-white transition-colors duration-200 hover:bg-orange-500">Wedstrijd aanmaken</a>
          </div>';
    } ?>

    <div class="grid grid-cols-1 gap-8 p-8 lg:grid-cols-2">
    <?php while ($wedstrijd = $stmtWedstrijden->fetch(PDO::FETCH_ASSOC)): ?>
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
        <div class="relative bg-white p-4 shadow-md rounded-md text-center">
            <p class="text-lg font-semibold mb-2"><?= $teamA['name'] . ' - ' . $teamB['name'] ?></p>
            <p class="text-lg font-semibold mb-2"><?= $wedstrijd['score_a'] . ' - ' . $wedstrijd['score_b'] ?></p>
            <p>Datum: <?= $wedstrijd['datum'] ?></p>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['admin'] == true): ?>
                <a href="wedstrijdEdit.php?id=<?= $wedstrijd['id'] ?>" class="absolute top-0 right-0 bg-blue-400 text-white px-4 py-2 rounded-md hover:bg-blue-500 transition-colors duration-200">Bewerken</a>
            <?php endif; ?>
        </div>
    <?php } else {// Handle case where fetch operation failed (no results found)
          echo '<div class="bg-white p-4 shadow-md rounded-md text-center">No data available</div>';}
        endwhile; ?>
    </div>
  </body>

  <script src="js/functions.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', hamburger());
  </script>
</html>
