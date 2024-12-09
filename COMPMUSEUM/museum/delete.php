<?php
session_start();

// Check if the user is logged in
if(!$_SESSION['loggedin']){
    header("Location: ./index.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_computermuseum";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection is successful
if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the 'delete' parameter from the URL
$delete = $_GET["delete"];



// Execute the delete query
if(mysqli_query($conn, "DELETE FROM `tb_museumartikelen` WHERE `id`='$delete'")){
    header("Location: ../index.php");
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
