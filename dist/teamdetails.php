<?php
require_once 'php/components.php';
require_once 'php/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoetbalToernooi | TeamDetails</title>
    <link rel="stylesheet" href="./style/output.css">
</head>
<?= htmlHeader() ?>
<body>
    <?php
    // Get team id from teams.php through url
    $id = $_GET['id'];

    // Get the team with the corresponding id
    $team = getTeam($id);

    // Get the players that have the teamID
    $players = getPlayers($id);
    ?>

    <div class="flex justify-center">
        <div class="mx-auto max-w-4xl">
            <div class="mt-12">
                <div class='box-border border-8 border-zinc-500 p-4 text-center'>
                    <!-- Display team name -->
                    <div class="mb-4 font-bold text-xl">Team Name: <?= $team['name'] ?></div>

                    <h3 class="mb-2">Players:</h3>                        
                    <!-- Loop through players and display their names -->
                    <div class="grid grid-cols-1 md:grid-cols-2">

                    <?php foreach ($players as $player) {
                      echo '<div class="mb-2 mx-2 ">' . $player['first_name'] . ' ' . $player['last_name'] . '</div>';
                    } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>


<script src="./js/functions.js"></script>
<script>document.addEventListener('DOMContentLoaded', hamburger());</script>
</html>