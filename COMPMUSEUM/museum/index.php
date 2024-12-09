<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>museum</title>
  <link rel="stylesheet" href="../css/stylesheet2.css">
</head>

<body> 
<header>
<?php 
include '../partials/header.php';



session_start();

ini_set('display_errors', 0);

if($_SESSION['loggedin']){
  echo ' 
  <form method="post" action="process.php" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="title">
    <input type="text" name="description" placeholder="description">
    <input type="file" name="image" accept=".jpg, .jpeg, .png">
    <button type="submit">Submit</button>
  </form>';

  echo ' <form action="sessionDestroy.php" method="post">
  <button type="submit"> Logout</button>
  </form>   ';

}


?>
<input type="text" id="searchInput" oninput="searchItems()" placeholder="Search...">
<p> Het computermuseum van Egbert Buchem</p>

</header>
<div id="searchResults"></div>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_computermuseum";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM tb_museumartikelen";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  echo "<div class='artikelen'>"; 
  
  while($row = mysqli_fetch_assoc($result)) {
    echo "<div class='artikel'>"; 
    echo "<div class='title'>" . $row["title"] . "</div>";
    $imagePath = "../images/db-images/museum_" . $row["id"] . ".png";

    if (file_exists($imagePath)) {
      echo '<img id="img1" src="' . $imagePath . '" >';
    }

    if ($_SESSION['loggedin']) {
      echo "<a href='./delete.php/?delete=". $row["id"] . "'>Delete</a>";
    }

    echo "<div class='description'>" . $row["description"] .  "</div>" . "</div>";  
  }
  echo "</div>";
} else {
  echo "0 results";
}

mysqli_close($conn);
?>

<style> 
  body {
    background-color: #ad9253;
  }
</style>

</body>


<script>
function searchItems() {
    var searchQuery = document.getElementById('searchInput').value;

    if (searchQuery.length < 1) {
        document.getElementById('searchResults').innerHTML = ''; 
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'search.php?query=' + searchQuery, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var results = xhr.responseText.trim(); // Trim to remove any unwanted extra spaces/newlines
            document.getElementById('searchResults').innerHTML = results;
        }
    };
    xhr.send();
}

</script>
</html>
