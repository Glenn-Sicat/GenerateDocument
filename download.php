<?php
    require ("connectionDb.php");

    $database = new Database();
    $mysqli = $database->getConnection();

    if (isset($_GET['id'])) {
        $documentId = intval($_GET['id']);
    
        $query = "SELECT name, content FROM documents WHERE id = ?";

        $stmt = $mysqli->stmt_init();
        if(!$stmt->prepare($query)){
            die("SQL Error". $mysqli->error);
        }
        $stmt->bind_param("i", $documentId);
        $stmt->execute();
        $stmt->bind_result($fileName, $fileContent);
        $stmt->fetch();
    
        if ($fileName && $fileContent) {
            // Serve the document as a downloadable file
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            echo $fileContent;
        } else {
            echo "Document not found.";
        }
        // Close the statement and connection
        $stmt->close();
        $mysqli->close();   
    } else {
        echo "No document ID provided.";
    }
?>