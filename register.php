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
  <!-- Datatable Includes -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
</head>

<body>
  <!-- Gets the tournament that was selected from the query in the url after the ? -->
  <script>
    $(document).ready(function() {
      //gets the tournament id from the url
      var param = window.location.href.split('?')[1];
      if (!Number.isInteger(parseInt(param))) {
        window.location.href = "/tournaments.php";
      }
      var tournamentId = parseInt(param);

      //gets the name of the tournament
      $.get(`PHPRequests/GetTournamentNameById.php?tournamentId=${tournamentId}`, function(title) {
        $('.title').append(title[0].tournamentName);
      });

      //calls the php as a GET request with params in the url and returns the results as json into the data variable
      $.get(`PHPRequests/GetRegisteredUserByTournamentID.php?tournamentId=${tournamentId}`, function(users) {
        //inserts the json response into the datatable
        console.log(users);
        for (var i = 0; i < users.length; i++) {
          var row = "<tr><td>" + users[i].username + "</td><td>" + users[i].email + "</td></tr>";
          $("#UserDatatable tbody").append(row);
        }
        //sets up the datatable and options
        $('#UserDatatable').DataTable({
          "paging": true,
          "info": false,
          "searching": true,
          "columnDefs": [{
            "targets": [1],
            "orderable": true
          }]
        });

      });
    });
  </script>

  <!-- import header component -->
  <?php include 'Components/header.php'; ?>

  <div class="content">
    <a href="/tournaments.php">Back to Tournaments</a>
    <h1 class="title">Registering for </h1>

    <!-- registered user table here -->
    <h1>Current Registered Users</h1>
    <table id="UserDatatable" class="display">
      <thead>
        <tr>
          <th>Username</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <!-- Data insterted here -->
      </tbody>
    </table>

  </div>
</body>

</html>