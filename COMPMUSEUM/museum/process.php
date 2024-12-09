<?php
require_once("../includes/database.inc.php");

$query = "SELECT MAX(id) as max_id FROM tb_museumartikelen";
$result = Database::getData($query);
session_start();
if(!$_SESSION['loggedin']){
    header("Location: ./index.php");
    exit;
}

if (!empty($result)) {
    $row = $result[0];
    $id = $row['max_id'] + 1;
    $uploadDir = "../images/db-images/museum_";
    $uploadFile = $uploadDir . $id . ".png";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
        if (isset($_FILES["image"]) && move_uploaded_file($_FILES["image"]["tmp_name"], $uploadFile)) {
            
        } else {
            // copy a default image
            copy("../images/db-images/standardImage.png", $uploadFile);
        }

        //  validate input
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);

        if ($title && $description) {
            // insert data into the database 
            $sql = "INSERT INTO tb_museumartikelen (id, title, description) VALUES (?, ?, ?)";
            $params = [$id, $title, $description];

            try {
                Database::getData($sql, $params);
                header("Location: ./index.php");
                exit;
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Invalid input data.";
        }
    }
} else {
    echo "Error fetching max ID.";
}
?>
