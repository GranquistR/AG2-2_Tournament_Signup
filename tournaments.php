<?php function getAllTournaments() //php function that fetches json from sql
{
  //gets the db login info from the config file
  //this config file is ignored by git via the .gitignore file
  //you will have to setup the config file on your own
  //DM Ryan if you have questions on how it works / how to set it up
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
  $sql = "SELECT * FROM test";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $results = $stmt->fetchAll();
  //returns the results as json
  return json_encode($results);
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tournaments</title>
  <script src="/Libraries/jquery-3.7.1.js"></script>
  <style>
    th, td {
      text-align: center;
    }
  </style>
</head>

<body><!-- Viewable page content here  -->
  Tournament page!
  <h1>Tournaments</h1>
  <h2>Please select a tournament</h2>
  <div class="grid-container">
    <div class = "grid-item">
      <table class ="testTable">
        <tr>
          <td><label for="tSearch">Search:</label></td>
          <td><input type="text" id="tSearch" name="search"></td>
        </tr>
      </table>
    </div>
    <div class = "grid-item">
      <table style = "width:50%", class = "testTable">
        <tr>
          <th>Tournament Name</th>
          <th>Description</th>
          <th>Spots Available</th>
          <th>Select</th>
        </tr>
        <tr>
          <td>Mortal Kombat</td>
          <td>Extremely family-friendly tournament where you become friends with everyone</td>
          <td>3</td>
          <td><input type="radio" id="mk" name="tournament[]" value="Mortal Kombat"></td>
        </tr>
      </table>
    </div>
  </div>
  <script>
    //prints from sql in the php above
    var tournaments = <?php echo getAllTournaments(); ?>;
    $(document).ready(function() {
      $("body").append("<div>" + JSON.stringify(tournaments) + "</div>");
    });
  </script>
</body>

</html>