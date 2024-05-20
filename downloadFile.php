<?php
    require 'connectionDb.php';

    $database = new Database();
    $mysqli = $database->getConnection();

    $query = "SELECT id, name FROM documents";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<form action = "download.php" method="get">';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
            echo '<button type="submit">Download ' . htmlspecialchars($row['name']) . '</button>';
            echo '</form>';
        }
    } else {
        echo "No documents found.";
    }

    $mysqli->close();
?>