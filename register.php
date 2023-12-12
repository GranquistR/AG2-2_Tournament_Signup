<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- jQuery include -->
  <script src="/Libraries/jquery-3.7.1.js"></script>
  <link rel="stylesheet" href="Stylesheet/Tournament.css">
  <link rel="stylesheet" href="Stylesheet/register.css">
  <!-- Datatable Includes -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
  <!-- Modal Styling -->
  <link rel="stylesheet" href="Stylesheet/confirmModal.css">
</head>

<body>
  <!-- Gets the tournament that was selected from the query in the url after the ? -->
  <script>
    $(document).ready(function () {
      //gets the tournament id from the url
      var param = window.location.href.split('?')[1];
      if (!Number.isInteger(parseInt(param))) {
        window.location.href = "/tournaments.php";
      }
      var tournamentId = parseInt(param);

      //gets the name of the tournament
      $.get(`PHPRequests/GetTournamentNameById.php?tournamentId=${tournamentId}`, function (title) {
        $('.title').append(title[0].tournamentName);
      });

      //calls the php as a GET request with params in the url and returns the results as json into the data variable
      $.get(`PHPRequests/GetRegisteredUserByTournamentID.php?tournamentId=${tournamentId}`, function (users) {
        //inserts the json response into the datatable
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

      //registers the user for the tournament
      $('.register').click(function () {
        var participantId = 2; //get user ID from somewhere?
        //calls the php as a GET request with params in the url and returns the results as json into the data variable
        $.get(`PHPRequests/AddUserToTournament.php?tournamentId=${tournamentId}&participantId=${participantId}`, function (data) {
          //if data starts with Failed
          if (data.startsWith("Failed")) {
            alert("Failed to join tournament. Please check you are not already registered and try again.");
          } else {
            alert("Successfully registered for tournament!");
            //scuffed reload
            window.location.href = window.location.href;
          }

        });
      });
    });
  </script>

  <!-- import header component -->
  <?php include 'Components/header.php'; ?>

  <div class="content">
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

    <button id="registerButton">REGISTER HERE</button>
    <div id="confirmModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <span class="close">&times;</span>
          <h2>Confirm Tournament Registration</h2>
        </div>
        <div class="modal-body">
          <p>Press the button below to confirm registration</p>
        </div>
        <div class="modal-footer">
          <button class="register">Register</button>
        </div>
      </div>
    </div>
    <script src="Scripts/confirmModal.js"></script>

    <a class = "back-to-tourney" href="/tournaments.php">Back to Tournaments</a>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
  </div>
</body>

</html>