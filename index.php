<?php function getUsers() //php function that fetches json from sql
{
    //gets the db login info from the config file
    //this config file is ignored by git via the .gitignore file
    //you will have to setup the config file on your own
    //DM Ryan if you have questions on how it works / how to set it up
    $config = parse_ini_file('env.config');
    $host = $config['host'];
    $db = $config['db'];
    $user = $config['user'];
    $pass = $config['pass'];
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);
    //actual sql query here!
    $sql = "SELECT username FROM participants";
    $stmt = $pdo->prepare($sql);


    $stmt->execute();
    $usernames = $stmt->fetchAll(PDO::FETCH_COLUMN);
    //returns the results as json
    return json_encode($usernames);
}
?>

<?php
// Decode the JSON list
$userData = json_decode(getUsers(), true);
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered username
    $enteredUsername = $_POST["username"];

    // Check if the entered username is in the list
    if (in_array($enteredUsername, $userData)) {
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