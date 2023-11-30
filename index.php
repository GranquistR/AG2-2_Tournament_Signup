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
</head>
<body>

    <h2>Login</h2>

    <?php
    // Display error message if any
    if (isset($errorMessage)) {
        echo '<p style="color: red;">' . $errorMessage . '</p>';
    }
    ?>

    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <input type="submit" value="Login">
    </form>

</body>
</html>