<?php
require_once 'php/components.php';
require_once 'php/db.php';
require_once 'php/functions.php';
redirectToLoginIfNotLoggedIn();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Validate and process form data
  $teamAId = $_POST['team_a_id'];
  $teamBId = $_POST['team_b_id'];
  $wedstrijdDate = $_POST['wedstrijd_date'];

  // Check if fields are not empty
  if (empty($teamAId) || empty($teamBId) || empty($wedstrijdDate)) {
    echo '<div class="bg-red-500 p-4 text-white">All fields are required. Please fill out the form completely.</div>';
  } else {
    // Check if teams are different
    if ($teamAId === $teamBId) {
      echo '<div class="bg-red-500 p-4 text-white">Please select different teams for Team A and Team B.</div>';
    } else {
      // Date format validation
      if (!strtotime($wedstrijdDate)) {
        echo '<div class="bg-red-500 p-4 text-white">Invalid date format. Please enter a valid date.</div>';
      } else {
        $queryCheckTeamsExist = 'SELECT COUNT(*) FROM team WHERE id IN (:teamAId, :teamBId)';
        $stmtCheckTeamsExist = $pdo->prepare($queryCheckTeamsExist);
        $stmtCheckTeamsExist->bindParam(':teamAId', $teamAId, PDO::PARAM_INT);
        $stmtCheckTeamsExist->bindParam(':teamBId', $teamBId, PDO::PARAM_INT);
        $stmtCheckTeamsExist->execute();
        $teamCount = $stmtCheckTeamsExist->fetchColumn();

        if ($teamCount < 2) {
          echo '<div class="bg-red-500 p-4 text-white">One or more selected teams do not exist.</div>';
        } else {
          // Ensure that wedstrijd date is in the future
          $currentDate = date('Y-m-d');
          if ($wedstrijdDate <= $currentDate) {
            echo '<div class="bg-red-500 p-4 text-white">Wedstrijd date must be in the future.</div>';
          } else {
            // Insert new wedstrijd into database
            $queryInsertWedstrijd = 'INSERT INTO wedstrijd (team_a_id, team_b_id, datum) VALUES (:teamAId, :teamBId, :wedstrijdDate)';
            $stmtInsertWedstrijd = $pdo->prepare($queryInsertWedstrijd);
            $stmtInsertWedstrijd->bindParam(':teamAId', $teamAId, PDO::PARAM_INT);
            $stmtInsertWedstrijd->bindParam(':teamBId', $teamBId, PDO::PARAM_INT);
            $stmtInsertWedstrijd->bindParam(':wedstrijdDate', $wedstrijdDate);

            if ($stmtInsertWedstrijd->execute()) {
              // Redirect to wedstrijden page after successful creation
              header('Location: wedstrijden.php');
              exit();
            } else {
              // Handle case where insert operation failed
              echo '<div class="bg-red-500 p-4 text-white">Failed to create a match. Please try again.</div>';
            }
          }
        }
      }
    }
  }
}

// Fetch teams for  dropdown menu
$queryGetAllTeams = 'SELECT * FROM team';
$stmtTeams = $pdo->query($queryGetAllTeams);
?>

<!doctype html>
<?php htmlhead('Wedstrijd aanmaken'); ?>
<html lang="en">
  <body>
    <?php htmlheader(); ?>

    <div class="mt-4 flex justify-center px-8 py-4">
      <a href="match.php" class="rounded-md bg-orange-400 px-4 py-2 text-white transition-colors duration-200 hover:bg-orange-500">Terug naar wedstrijden</a>
    </div>

    <div class="grid p-8">
      <form method="post" action="wedstrijdCreation.php" class="bg-white p-4 shadow-md rounded-md text-center">
        <p class="text-lg font-semibold mb-2">Wedstrijd aanmaken</p>

        <label for="team_a">Team A:</label>
        <select name="team_a_id" id="team_a" required>
          <?php while ($team = $stmtTeams->fetch(PDO::FETCH_ASSOC)): ?>
            <option value="<?= $team['id'] ?>"><?= $team['name'] ?></option>
          <?php endwhile; ?>
        </select>

        <label for="team_b">Team B:</label>
        <select name="team_b_id" id="team_b" required>
          <?php $stmtTeams->execute(); ?>
          <?php while ($team = $stmtTeams->fetch(PDO::FETCH_ASSOC)): ?>
            <option value="<?= $team['id'] ?>"><?= $team['name'] ?></option>
          <?php endwhile; ?>
        </select>

        <label for="wedstrijd_date">Match Date:</label>
        <input type="date" name="wedstrijd_date" id="wedstrijd_date" required>

        <button type="submit" class="rounded-md bg-blue-400 px-4 py-2 text-white transition-colors duration-200 hover:bg-blue-500">Create</button>
      </form>
    </div>
  </body>

  <script src="js/functions.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', hamburger());
  </script>
</html>
