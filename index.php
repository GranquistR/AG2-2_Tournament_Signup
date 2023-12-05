<?php
// Sample JSON list of usernames
$userList = '{
    "usernames": ["user1", "user2", "user3"]
}';

// Decode the JSON list
$userData = json_decode($userList, true);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered username
    $enteredUsername = $_POST["username"];

    // Check if the entered username is in the list
    if (in_array($enteredUsername, $userData["usernames"])) {
        // Redirect to tournaments.php

        header("Location: tournaments.php");
        exit();
    } else {
        // Display an error message
        $errorMessage = "Invalid username. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="Stylesheet/login.css">
  
</head>

<body>
    <div class="login-box">

        <h2>Login</h2>

        <form method="post" action="">
            <div class="user-box">
                <input autocomplete="new-password" type="text" id="username" name="username" required>
                <label>Username</label>
            </div>
            <div class="user-box">
                <input type="password" id="password" name="password" required>
                <label>Password</label>
            </div>
            <input id="submitbutton" type="submit" value="Submit">
            </input>
            <p id=errmsg style="color: red"></p>
            <?php
            // Display error message if any
            if (isset($errorMessage)) {
                ?>
                <p id=errmsg><?= $errorMessage ?></p>
                <?php
            }
            ?>
        </form>
    </div>

    <script src="Scripts\storeUsername.js"></script>

</body>

</html>