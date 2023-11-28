<?php function getAllTournaments() //php function that fetches json from sql
{
  //gets the db login info from the config file
  //this config file is ignored by git
  //DM Ryan if you have questions on how to set this up
  $config = parse_ini_file('env.config');
  //configures db login with said config file
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

  $sql = "SELECT * FROM test";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $results = $stmt->fetchAll();

  return json_encode($results);
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tournaments</title>
  <script src="/Libraries/jquery-3.7.1.js"></script>
</head>

<body><!-- Viewable page content here  -->
  Tournaments:
  <script>
    //prints from sql in php above
    var tournaments = <?php echo getAllTournaments(); ?>;
    $(document).ready(function() {
      $("body").append("<div>" + JSON.stringify(tournaments) + "</div>");
    });
  </script>

</body>

</html>