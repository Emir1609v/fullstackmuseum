<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_computermuseum";

ini_set('display_errors', 0);


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $stmt = $conn->prepare("SELECT * FROM tb_museumartikelen WHERE title LIKE ?");
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='artikelen'>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<div class='artikel'>"; 
            echo "<div class='title'>" . $row["title"] . "</div>";
            $imagePath = "../images/db-images/museum_" . $row["id"] . ".png";

            if (file_exists($imagePath)) {
                echo '<img class="artikel-image" src="' . $imagePath . '" alt="' . $row["title"] . '">';
            }

            echo "<div class='description'>" . $row["description"] . "</div>";

            if ($_SESSION['loggedin']) {
                echo "<a href='./delete.php/?delete=" . $row["id"] . "'>Delete</a>";
            }

            echo "</div>"; // Close .artikel
        }
        echo "</div>"; // Close .artikelen
    } else {
        echo "Fuck you, try again!";
    }
}

mysqli_close($conn);
?>
