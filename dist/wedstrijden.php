<?php
$pageName = 'Wedstrijden';
require_once 'php/functions.php';
redirectToLoginIfNotLoggedIn();
require_once 'php/db.php';
require_once 'php/components.php';
?>
<!DOCTYPE html>
<html lang="en">
    <?php htmlhead($pageName); ?>
<body>
  <?php htmlheader(); ?>

<?php
$pdo = connectToDatabase();
$QueryGetAllWedstrijden = 'SELECT * FROM wedstrijd';
$stmtWedstrijden = $pdo->query($QueryGetAllWedstrijden);
?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
    <?php while ($wedstrijd = $stmtWedstrijden->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="bg-white p-4 shadow-md rounded-md text-center">
            <!-- <p class="text-lg font-semibold mb-2">Wedstrijd ID: <?= $wedstrijd['id'] ?></p> -->
            <p class="text-lg font-semibold mb-2"><?= $wedstrijd['team_a_id'] . ' - ' . $wedstrijd['team_b_id'] ?></p>
            <p>Datum: <?= $wedstrijd['datum'] ?></p>
            <!-- <p>Team A ID: <?= $wedstrijd['team_a_id'] ?></p>
            <p>Team B ID: <?= $wedstrijd['team_b_id'] ?></p> -->
            <p>Score <?= $wedstrijd['team_a_id'] ?>: <?= $wedstrijd['score_a'] ?></p>
            <p>Score <?= $wedstrijd['team_b_id'] ?>: <?= $wedstrijd['score_b'] ?></p>
        </div>
    <?php endwhile; ?>
</div>


  
</body>
<script src="js/functions.js"></script>
<script>document.addEventListener('DOMContentLoaded', hamburger());</script>
</html>