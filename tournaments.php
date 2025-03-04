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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tournaments</title>
  <script src="/Libraries/jquery-3.7.1.js"></script>

  <!-- Datatable Includes -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
  <link rel="stylesheet" href="Stylesheet/Tournament.css">
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
</head>

<body><!-- Viewable page content here  -->

  <!-- import header component -->
  <?php include 'Components/Header.php'; ?>
  <div class="content">
    <h1>Tournaments</h1>
    <h2>Please select a tournament</h2>

    <!-- DataTable -->

    <!-- sets up the datatable and options -->
    <script>
      $(document).ready(function() {
        $('#TournamentDatatable').DataTable({
          "paging": true,
          "info": false,
          "searching": true,
          "columnDefs": [{
            "targets": [3],
            "orderable": true
          }],
          "language": {
            "emptyTable": "No tournaments available"
          }
        });
      });
    </script>

    <!-- creates the datatable template for the js to work with -->
    <table id="TournamentDatatable" class="display">
      <thead>
        <tr>
          <th>Tournament Name</th>
          <th>Description</th>
          <th>Max Participants</th>
          <th>View</th>
        </tr>
      </thead>
      <tbody>
        <script>
          //inserts the json response into the datatable
          var tournaments = <?php echo getAllTournaments(); ?>;
          for (var i = 0; i < tournaments.length; i++) {
            var tournamentRow = "<tr><td>" + tournaments[i].tournamentName + "</td><td>" + tournaments[i].description + "</td><td>" + tournaments[i].capacity + "</td><td><a class='viewbutton' href='/register.php?" + tournaments[i].tournamentID + "'>View</a></td></tr>";
            $("#TournamentDatatable tbody").append(tournamentRow);
          }
        </script>
      </tbody>
    </table>
  </div>
</body>

</html>