<?php

function connectToDatabase()
{
  $host = 'localhost';
  $dbname = 'voetbaltoernooi';
  $user = 'root';
  $password = '';

  try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
  }
}

function getTeam($id)
{
  try {
    // Establish a database connection
    $pdo = connectToDatabase();

    // Prepare and execute SQL query to retrieve team information
    $sql = 'SELECT * FROM team WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Fetch the result as an array
    $team = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the team information
    return $team;
  } catch (PDOException $e) {
    // Handle database-related errors and return false
    print 'Error: ' . $e->getMessage();
    return false;
  } finally {
    // Close the database connection in all cases
    $pdo = null;
  }
}

function getPlayers($teamID)
{
  try {
    // Establish a database connection
    $pdo = connectToDatabase();

    // Prepare and execute SQL query to retrieve player IDs associated with the team
    $sql = 'SELECT user_id FROM user_has_team WHERE team_id = :team_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':team_id', $teamID);
    $stmt->execute();

    // Fetch all player IDs as an array
    $playerIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Initialize an array to store player information
    $players = [];

    // Loop through player IDs, retrieve user information, and add to the players array
    foreach ($playerIds as $playerId) {
      $user = getUser($playerId);
      if ($user) {
        $players[] = $user;
      }
    }

    // Return the array of player information
    return $players;
  } catch (PDOException $e) {
    // Handle database-related errors and return false
    print 'Error: ' . $e->getMessage();
    return false;
  } finally {
    // Close the database connection in all cases
    $pdo = null;
  }
}

function getUser($userId)
{
  try {
    // Establish a database connection
    $pdo = connectToDatabase();

    // Prepare and execute SQL query to retrieve user information
    $sql = 'SELECT * FROM user WHERE id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    // Fetch the result as an array
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the user information
    return $user;
  } catch (PDOException $e) {
    // Handle database-related errors and return false
    print 'Error: ' . $e->getMessage();
    return false;
  } finally {
    // Close the database connection in all cases
    $pdo = null;
  }
}
