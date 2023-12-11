<?php
$pageName = 'teamCreation';
require_once 'php/functions.php';
redirectToLoginIfNotLoggedIn();
require_once 'php/components.php';
require_once 'php/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teamcreation</title>
    <link rel="stylesheet" href="./style/output.css">
</head>
<body>
    <?= htmlHeader() ?>
<?php // Check if the user is logged in


if (!isset($_SESSION['id'])) {
  header('Location: login.php'); // Redirect to login page if not logged in
  exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Handle form submission
  $teamName = $_POST['team_name'];
  $userId = $_SESSION['id']; // Validate form data
  if (empty($teamName)) {
    $error = 'Team name is required';
  } else {
    // Save team information to database
    $pdo = connectToDatabase(); // Prepare and execute the query
    $createQuery = 'INSERT INTO team (name, user_id) VALUES (?, ?)';
    $stmt = $pdo->prepare($createQuery);
    $stmt->execute([$teamName, $userId]); // Close the database connection
    $pdo = null; // Redirect to success page or other page
    header('Location: teams.php');
    exit();
  }
}
?>

    <div class="container mx-auto mt-8 p-8 bg-white rounded-md shadow-md max-w-md">
        <h2 class="text-2xl font-bold mb-4">Create Your Team</h2>

        <?php if (isset($error)): ?>
            <p class="text-red-500 mb-4"><?= $error ?></p>
        <?php endif; ?>

        <form method="post">
            <div class="mb-4">
                <label for="team_name" class="block text-sm font-medium text-gray-600">Team Name</label>
                <input type="text" id="team_name" name="team_name" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="px-4 py-2 bg-orange-400 text-white rounded-md hover:bg-orange-500 transition-colors duration-200">Create Team</button>
                <a href="teams.php" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>

</body>

</html>
</body>
</html>