<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- jQuery include -->
  <script src="/Libraries/jquery-3.7.1.js"></script>
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
      $('.title').append(tournamentId);
    });
  </script>

  <a href="/tournaments.php">Back to Tournaments</a>
  <h1 class="title">Registering for tournament id: </h1>
</body>

</html>