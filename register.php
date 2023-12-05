<?php function getTournamentName($tournamentID) //php function that fetches json from sql
{
  $config = parse_ini_file('env.config');
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
  $sql = "SELECT tournamentName FROM tournament WHERE tournamentID = '".$tournamentID."'";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();


  $results = $stmt->fetchAll();
  //returns the results as json
  return json_encode($results);
}
?>

<?php function enterTournament($tournament) // php function to join a tournament
{
  // access db
  $config = parse_ini_file('env.config');
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

  // need user
  $participant = "user1";

  // sql code
  $sql = "INSERT INTO participatesIn VALUES ($tournament, $participant.participatnID);";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- jQuery include -->
  <script src="/Libraries/jquery-3.7.1.js"></script>
  <link rel="stylesheet" href="Stylesheet/Tournament.css">

</head>

<body>
  <!-- Gets the tournament that was selected from the query in the url after the ? -->
  <script>
    $(document).ready(function() {
      var param = window.location.href.split('?')[1];
      if (!Number.isInteger(parseInt(param))) {
        window.location.href = "/tournaments.php";
      }
      var tournamentId = parseInt(param);
      $('.title').append(<?php echo getTournamentName($tournamentId['tournamentId']) ?>);
    });
  </script>

  <!-- import header component -->
  <?php include 'Components/header.php'; ?>

  <div class="content">
    <a href="/tournaments.php">Back to Tournaments</a>
    <h1 class="title">Registering for /h1>
  </div>
</body>

</html>