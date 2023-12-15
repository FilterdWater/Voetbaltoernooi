<?php
require_once 'php/components.php';
require_once 'php/db.php';
require_once 'php/functions.php';
redirectToLoginIfNotLoggedIn();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['delete'])) {
    // Delete the wedstrijd from the database
    $wedstrijdId = $_POST['wedstrijd_id'];
    $deleteQuery = 'DELETE FROM wedstrijd WHERE id = ?';
    $stmtDelete = $pdo->prepare($deleteQuery);
    $stmtDelete->execute([$wedstrijdId]);

    // Redirect to the wedstrijden page after deletion
    header('Location: wedstrijden.php');
    exit();
  }
  // if post isnt delete update instead
  $wedstrijdId = $_POST['wedstrijd_id'];
  $scoreA = $_POST['score_a'];
  $scoreB = $_POST['score_b'];

  // Validate form data
  if (empty($wedstrijdId) || !is_numeric($wedstrijdId)) {
    $error = 'Invalid input';
  } else {
    // Update wedstrijd information in the database
    $updateQuery = 'UPDATE wedstrijd SET score_a = ?, score_b = ? WHERE id = ?';
    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute([$scoreA, $scoreB, $wedstrijdId]);
    // Redirect to the same page or other page
    header('Location: wedstrijden.php');
    exit();
  }
}

// Fetch wedstrijd details
$wedstrijdId = $_GET['id'];
$fetchWedstrijdQuery = 'SELECT * FROM wedstrijd WHERE id = ?';
$stmtWedstrijd = $pdo->prepare($fetchWedstrijdQuery);
$stmtWedstrijd->execute([$wedstrijdId]);
$wedstrijdDetails = $stmtWedstrijd->fetch(PDO::FETCH_ASSOC);

// Fetch team details for team A and team B
$teamAId = $wedstrijdDetails['team_a_id'];
$teamBId = $wedstrijdDetails['team_b_id'];

$queryGetTeamA = 'SELECT * FROM team WHERE id = ?';
$queryGetTeamB = 'SELECT * FROM team WHERE id = ?';

$stmtTeamA = $pdo->prepare($queryGetTeamA);
$stmtTeamB = $pdo->prepare($queryGetTeamB);

$stmtTeamA->execute([$teamAId]);
$stmtTeamB->execute([$teamBId]);

$teamA = $stmtTeamA->fetch(PDO::FETCH_ASSOC);
$teamB = $stmtTeamB->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<?php htmlhead('Wedstrijd Bewerken'); ?>
<html lang="en">
<body>
    <?php htmlheader(); ?>

    <div class="container mx-auto mt-8 p-8 bg-white rounded-md border border-gray-300 max-w-md">
        <h2 class="text-2xl font-bold mb-4">Wedstrijd Bewerken</h2>

        <?php if (isset($error)): ?>
            <p class="text-red-500 mb-4"><?= $error ?></p>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="wedstrijd_id" value="<?= $wedstrijdId ?>">

                <div class="mb-4">
                    <h3 class="text-lg font-semibold mb-2">Wedstrijd Details</h3>
                    <p><strong>Teams:</strong> <?= $teamA['name'] ?> vs <?= $teamB['name'] ?></p>
                    <p><strong>Datum:</strong> <?= date('Y-m-d', strtotime($wedstrijdDetails['datum'])) ?></p>
                </div>

                <div class="mb-4">
                    <label for="score_a" class="block text-sm font-medium text-gray-600">Score Team A</label>
                    <input type="number" min="0" id="score_a" name="score_a" value="<?= $wedstrijdDetails['score_a'] ?>" class="mt-1 p-2 w-full border rounded-md">
                </div>

                <div class="mb-4">
                    <label for="score_b" class="block text-sm font-medium text-gray-600">Score Team B</label>
                    <input type="number" min="0" id="score_b" name="score_b" value="<?= $wedstrijdDetails['score_b'] ?>" class="mt-1 p-2 w-full border rounded-md">
                </div>

                <?php if ($wedstrijdDetails['datum'] !== '0000-00-00 00:00:00'): ?>
                    <div class="mb-4">
                        <label for="datum" class="block text-sm font-medium text-gray-600">Datum</label>
                        <input type="date" id="datum" name="datum" value="<?= date('Y-m-d', strtotime($wedstrijdDetails['datum'])) ?>" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                <?php endif; ?>

                <div class="flex items-center justify-between">
                    <button type="submit" class="px-4 py-2 bg-blue-400 text-white rounded-md hover:bg-blue-500 transition-colors duration-200">Opslaan</button>
                    <a href="wedstrijden.php" class="text-gray-600 hover:underline underline-offset-4">Annuleren</a>
                </div>

        </form>

        <!-- Delete form -->
        <form method="post" onsubmit="return confirm('Are you sure you want to delete this wedstrijd?');">
            <input type="hidden" name="wedstrijd_id" value="<?= $wedstrijdId ?>">
            <button type="submit" name="delete" class="px-4 py-2 bg-red-500 text-white rounded-md mt-4 hover:bg-red-600 transition-colors duration-200">Verwijderen</button>
        </form>
    </div>

</body>

<script src="js/functions.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', hamburger());
</script>
</html>
