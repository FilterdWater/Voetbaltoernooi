<?php
$host = 'localhost';
$dbname = 'voetbaltoernooi';
$user = 'root';
$password = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
}

?>
