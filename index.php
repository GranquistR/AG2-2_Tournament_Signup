<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="Stylesheet/login.css">
    <script src="/Libraries/jquery-3.7.1.js"></script>

</head>

<body>

    <script>
        $(document).ready(function() {
            $("#submitbutton").click(function() {
                var username = $("#usernameInput").val();
                alert(username);
                $.get(`PHPRequests/LoginByUsername.php?usernameAttempt=${username}`, function(data) {
                    console.log(data)
                    if (data == "[]") {
                        localStorage.clear();
                    } else {
                        localStorage.clear();
                        var userInfo = JSON.parse(data);
                        localStorage.setItem("enteredUsername", userInfo[0].username);
                        localStorage.setItem("participantId", userInfo[0].participantID);
                        window.location.href = "/tournaments.php";
                    }
                });
            });
        });
    </script>

    <div class="login-box">

        <h2>Login</h2>

        <div class="user-box">
            <input id="usernameInput"> </input>
            <label>Username</label>
        </div>
        <div class="user-box">
            <input> </input>
            <label>Password</label>
        </div>
        <button id="submitbutton">
            Submit
        </button>


    </div>

</body>

</html>