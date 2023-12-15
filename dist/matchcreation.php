<?php
require_once 'php/components.php';
require_once 'php/db.php';
require_once 'php/functions.php';
redirectToLoginIfNotLoggedIn();

$QueryGetAllmatches = 'SELECT * FROM team';
$stmtteams = $pdo->query($QueryGetAllmatches);
?>
<!doctype html>
<?php htmlhead('matchCreation'); ?>
<html lang="en">
<body>
	<?php htmlheader(); ?>
	<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
		<div class="flex justify-center lg:justify-end w-full">
			<!-- form wrapper -->
			<div class="flex flex-col w-fit h-fit">
				<label for="team-select" class="text-center">Team A</label>
				<select class="rounded shadow-sm border-gray-200 mt-1" name="teams" id="team-select">
					<option disabled hidden selected="selected">Please choose a team</option>
					<option value="dog">monkeys</option>
				</select>
			</div>
		</div>
		<div class="flex justify-center lg:justify-start w-full">
			<!-- form wrapper -->
			<div class="flex justify-center flex-col w-fit h-fit">
				<label for="team-select" class="text-center">Team B</label>
				<select class="rounded shadow-sm border-gray-200 mt-1" name="teams" id="team-select">
					<option disabled hidden selected="selected">Please choose a team</option>
					<option value="dog">monkeys</option>
				</select>
			</div>
		</div>
		<div class="justify-center flex lg:col-span-2">
			<div class=" flex flex-col">
				<label class="text-gray-700">When is the match?</label>
				<input type="date" class="mt-1 block w-fit rounded-md border-gray-300 shadow-sm">
			</div>
		</div>
	</div>

	
</body>

  <script src="js/functions.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', hamburger());
  </script>
</html>
