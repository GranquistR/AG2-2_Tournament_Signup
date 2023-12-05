<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$config = parse_ini_file('../env.config');
$host = $config['host'];
$db   = $config['db'];
$user = $config['user'];
$pass = $config['pass'];
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

//actual sql query here!
$sql = "SELECT tournamentName FROM tournament WHERE tournamentID = $_GET[tournamentId]";
$stmt = $pdo->prepare($sql);
$stmt->execute();


$results = $stmt->fetchAll();
//returns the results as json
echo json_encode($results);
