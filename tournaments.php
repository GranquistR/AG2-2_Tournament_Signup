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
  $sql = "SELECT * FROM tournament";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $results = $stmt->fetchAll();
  //returns the results as json
  return json_encode($results);
}

$storedUsername = "<script>document.write(localStorage.getItem('enteredUsername'));</script>";
if ($storedUsername) {
  echo '<p>Welcome, ' . $storedUsername . '!</p>';
} else {
  // Redirect back to the login page if the username is not found
  header("Location: login.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tournaments</title>
  <script src="/Libraries/jquery-3.7.1.js"></script>
  <style>
    th,
    td {
      text-align: center;
    }
  </style>
  <!-- Datatable Includes -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
</head>

<body><!-- Viewable page content here  -->
  Tournament page!
  <h1>Tournaments</h1>
  <h2>Please select a tournament</h2>
  <!-- <script>
    //prints from sql in the php above
    var tournaments = <?php echo getAllTournaments(); ?>;
    $(document).ready(function() {
      $("body").append("<div>" + JSON.stringify(tournaments) + "</div>");
    });
  </script> -->
  <script>
    //sets up the datatable
    $(document).ready(function() {
      $('#TournamentDatatable').DataTable({
        "paging": true,
        "info": false,
        "searching": true,
        "columnDefs": [{
          "targets": [3],
          "orderable": true
        }]
      });
    });
    var tournaments = <?php echo getAllTournaments(); ?>;
    console.log(tournaments);
  </script>
  <table id="TournamentDatatable" class="display">
    <thead>
      <tr>
        <th>Tournament Name</th>
        <th>Description</th>
        <th>Spots Available</th>
        <th>Select</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Row 1 Data 1</td>
        <td>Row 1 Data 2</td>
        <td>Row 1 Data 3</td>
        <td>Row 1 Data 4</td>
      </tr>
      <tr>
        <td>Row 2 Data 1</td>
        <td>Row 2 Data 2</td>
        <td>Row 2 Data 3</td>
        <td>Row 2 Data 4</td>
      </tr>
      <tr>
        <td>Test</td>
        <td>Row 2 Data 2</td>
        <td>Row 2 Data 3</td>
        <td>Row 2 Data 4</td>
      </tr>
    </tbody>
  </table>
</body>

</html>