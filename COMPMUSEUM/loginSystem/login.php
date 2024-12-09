<form action="login.php" method="post">
  <label for="username">Username:</label>
  <input id="username" name="username" required="" type="text" />
  <label for="password">Password:</label> <input id="password" name="password" required="" type="password" />
  <input name="login" type="submit" value="Login" />
</form>

<?php
session_start();

// Check if the login form has been submitted
if (isset($_POST['login'])) {

    // Connect to the database
    $mysqli = new mysqli("localhost", "root", "", "db_computermuseum");

    // Check for connection errors
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement
    $stmt = $mysqli->prepare("SELECT id, password FROM user WHERE username = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $mysqli->error);
    }

    // Bind the parameter
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        // Bind the result to variables
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id();

            // Set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;

            // Redirect to the dashboard
            header("Location: ../index.php");
            exit;
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User not found!";
    }

    // Close the statement and connection
    $stmt->close();
    $mysqli->close();
}
?>
