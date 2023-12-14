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
    $(document).ready(function() {
      $('.content').hide();
      $('.ring').show();
      //gets the tournament id from the url
      var param = window.location.href.split('?')[1];
      if (!Number.isInteger(parseInt(param))) {
        window.location.href = "/tournaments.php";
      }
      var tournamentId = parseInt(param);
      var capacity = 0;
      var currRegistered = 0;
      var userIsRegistered = false;

      //gets the name and capacity of the tournament
      $.get(`PHPRequests/GetTournamentNameCapacityById.php?tournamentId=${tournamentId}`, function(title) {
        $('.title').append(title[0].tournamentName);

        capacity = title[0].capacity; 
        $('.numUsers').append(capacity);
      });

      //calls the php as a GET request with params in the url and returns the results as json into the data variable
      $.get(`PHPRequests/GetRegisteredUserByTournamentID.php?tournamentId=${tournamentId}`, function(users) {
          $('.numUsers').prepend("Current Registered Users: " + users.length + "/");
        //inserts the json response into the datatable
        for (var i = 0; i < users.length; i++) {
          currRegistered++;

          if (users[i].username == localStorage.getItem('enteredUsername')) {
            userIsRegistered = true;
            var row = "<tr><td style='color: yellow;'>" + users[i].username + "</td><td style='color: yellow;'>" + users[i].email + "</td></tr>";
          } else {
            var row = "<tr><td>" + users[i].username + "</td><td>" + users[i].email + "</td></tr>";
          }
          if (users[i].username == localStorage.getItem('enteredUsername')) {

          }
          $("#UserDatatable tbody").append(row);
        }
        if (currRegistered >= capacity) {
          // make the register button not work
          $('#registerButton').prop('disabled', true);
          // make the pointer not work
          $('#registerButton').css('cursor', 'not-allowed');
          $('#registerButton').html("Tournament is full!");
        }
        if (userIsRegistered) {
          // make the register button not work
          $('#registerButton').prop('disabled', true);
          // make the pointer not work
          $('#registerButton').css('cursor', 'not-allowed');
          $('#registerButton').html("You are registered!");
        }
        $('.ring').fadeOut(500);
        $('.content').fadeIn(1000);
        //sets up the datatable and options
        $('#UserDatatable').DataTable({
          "paging": true,
          "info": false,
          "searching": true,
          "columnDefs": [{
            "targets": [1],
            "orderable": true
          }],
          "language": {
            "emptyTable": "No users registered for this tournament"
          }
        });
      });

      //registers the user for the tournament
      $('#confirmButton').click(function() {
        if (currRegistered >= capacity) {
          alert("Tournament is full!");
          return;
        }
        var participantId = localStorage.getItem('participantId'); //get user ID from somewhere?
        //calls the php as a GET request with params in the url and returns the results as json into the data variable
        $.get(`PHPRequests/AddUserToTournament.php?tournamentId=${tournamentId}&participantId=${participantId}`, function(data) {
          //if data starts with Failed
          if (data.startsWith("Failed")) {
            alert("Failed to join tournament. Please check you are not already registered and try again.");
          } else {
            //scuffed reload
            window.location.href = window.location.href;
          }

        });
      });
    });
  </script>

  <!-- import header component -->
  <?php include 'Components/header.php'; ?>
  <div class="ring">Loading</div>
  <div class="content">
    <h1 class="title"></h1>

    <!-- registered user table here -->
    <h1 class="numUsers"></h1>
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

    <button class="register" id="registerButton">REGISTER HERE</button>
    <div id="confirmModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <span class="close">&times;</span>
          <h2>Confirm Tournament Registration</h2>

          <button class="register" id="confirmButton">Register</button>
        </div>
      </div>
    </div>
    <script src="Scripts/confirmModal.js"></script>

    <a class="back-to-tourney" href="/tournaments.php">Back to Tournaments</a>
  </div>
</body>

</html>