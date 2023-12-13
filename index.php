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
            <input autocomplete="new-password" id="usernameInput" name="username" required> </input>
            <label>Username</label>
        </div>
        <div class="user-box">
            <input type="password" id="password" name="password" required> </input>
            <label>Password</label>
        </div>
        <button id="submitbutton">
            Submit
        </button>


    </div>

</body>

</html>