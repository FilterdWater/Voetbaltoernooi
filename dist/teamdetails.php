<?php
require_once 'php/components.php';
require_once 'php/db.php';
require_once 'php/functions.php';
redirectToLoginIfNotLoggedIn();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $teamId = $_POST['team_id'];

  // Check which form was submitted
  if (isset($_POST['add_user'])) {
    // Add user to the team
    $userId = $_POST['user_id'];
    $createQuery = 'INSERT INTO user_has_team (user_id, team_id) VALUES (?, ?)';
    $stmt = $pdo->prepare($createQuery);
    $stmt->execute([$userId, $teamId]);
  } elseif (isset($_POST['remove_user'])) {
    // Remove user from the team
    $userId = $_POST['user_id'];
    $removeUserQuery = 'DELETE FROM user_has_team WHERE user_id = ? AND team_id = ?';
    $stmtRemoveUser = $pdo->prepare($removeUserQuery);
    $stmtRemoveUser->execute([$userId, $teamId]);
  } elseif (isset($_POST['delete_team'])) {
    // Delete the entire team
    $deleteTeamQuery = 'DELETE FROM team WHERE id = ?';
    $stmtDeleteTeam = $pdo->prepare($deleteTeamQuery);
    $stmtDeleteTeam->execute([$teamId]);

    // Redirect to the teams page after deletion
    header('Location: teams.php');
    exit();
  }

  // Redirect to the same team details page
  header("Location: teamdetails.php?id=$teamId");
  exit();
}

// Fetch team details
$teamId = $_GET['id'];
$fetchTeamQuery = 'SELECT * FROM team WHERE id = ?';
$stmtTeam = $pdo->prepare($fetchTeamQuery);
$stmtTeam->execute([$teamId]);
$teamDetails = $stmtTeam->fetch(PDO::FETCH_ASSOC);

// Fetch current team players
$fetchPlayersQuery = 'SELECT user.id, user.first_name, user.last_name 
                      FROM user
                      JOIN user_has_team ON user.id = user_has_team.user_id
                      WHERE user_has_team.team_id = ?';
$stmtPlayers = $pdo->prepare($fetchPlayersQuery);
$stmtPlayers->execute([$teamId]);
$teamPlayers = $stmtPlayers->fetchAll(PDO::FETCH_ASSOC);

// Fetch available users who are not in the team
$queryAvailableUsers = 'SELECT id, first_name, last_name FROM user WHERE id NOT IN (SELECT user_id FROM user_has_team WHERE team_id = ?)';
$stmtAvailableUsers = $pdo->prepare($queryAvailableUsers);
$stmtAvailableUsers->execute([$teamId]);
$availableUsers = $stmtAvailableUsers->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<?php htmlhead('teamdetails'); ?>
<html lang="en">
<body>
<?php htmlheader(); ?>

<div class="mt-4 flex justify-center px-8 py-4">
    <a href="teams.php" class="rounded-md bg-orange-400 px-4 py-2 text-white transition-colors duration-200 hover:bg-orange-500">Back to Teams</a>
</div>

<div class="container mx-auto mt-8 p-8 bg-white rounded-md border border-gray-300 max-w-3xl">
    <h2 class="text-2xl font-bold mb-4"><?= $teamDetails['name'] ?></h2>

    <?php if (isset($error)): ?>
        <p class="text-red-500 mb-4"><?= $error ?></p>
    <?php endif; ?>

    <?php if ($_SESSION['admin']): ?>
        <!-- Add user form -->
        <form method="post">
            <input type="hidden" name="team_id" value="<?= $teamId ?>">
            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-600">Add User to Team</label>
                <select name="user_id" id="user_id" class="mt-1 p-2 w-full border rounded-md">
                    <?php foreach ($availableUsers as $user): ?>
                        <option value="<?= $user['id'] ?>"><?= $user['first_name'] ?> <?= $user['last_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="add_user" class="px-4 py-2 mb-12 bg-green-400 text-white rounded-md hover:bg-green-500 transition-colors duration-200">Add User</button>
        </form>

        <!-- Remove user form -->
        <form method="post" onsubmit="return confirm('Are you sure you want to remove this user from the team?');">
            <input type="hidden" name="team_id" value="<?= $teamId ?>">
            <div class="mb-4">
                <label for="user_id_remove" class="block text-sm font-medium text-gray-600">Remove User from Team</label>
                <select name="user_id" id="user_id_remove" class="mt-1 p-2 w-full border rounded-md">
                    <?php foreach ($teamPlayers as $player): ?>
                        <option value="<?= $player['id'] ?>"><?= $player['first_name'] ?> <?= $player['last_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="remove_user" class="px-4 py-2 bg-red-500 text-white rounded-md mt-4 hover:bg-red-600 transition-colors duration-200">Remove User</button>
        </form>

        <!-- Delete team form -->
        <form method="post" onsubmit="return confirm('Delete werkt alleen als alles gerelateerd tot het team gedelete is. Oftewel, voordat je het team delete moet je eerst alle geplanden wedstrijden deleten en alle users uit het team gooien');">
            <input type="hidden" name="team_id" value="<?= $teamId ?>">
            <button type="submit" name="delete_team" class="px-4 py-2 bg-red-500 text-white rounded-md mt-4 hover:bg-red-600 transition-colors duration-200">Delete Team</button>
        </form>

    <?php endif; ?>

    <div class="mt-8">
        <h3 class="text-xl font-bold mb-4">Team Players</h3>
        <table class="w-full text-left">
            <tr class="border-b text-center">
                <th class="py-2">First name</th>
                <th class="py-2">Last name</th>
            </tr>
            <?php foreach ($teamPlayers as $player): ?>
                <tr class="border-b text-center">
                    <td class="py-2"><?= $player['first_name'] ?></td>
                    <td class="py-2"><?= $player['last_name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

</body>

<script src="js/functions.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', hamburger());
</script>
</html>
