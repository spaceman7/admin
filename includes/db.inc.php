<?php
global $pdo;
try
{
  $pdo = new PDO('mysql:host=localhost;dbname=naryad', 'root', 'Keeper');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
  $error = 'Не возможно соединиться с сервером.';
  include 'includes/error.html.php';
  exit();
}
