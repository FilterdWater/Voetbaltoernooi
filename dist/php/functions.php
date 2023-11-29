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
