<?php
require 'vendor/autoload.php';
require 'connectionDb.php';

use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['association']) &&
    isset($_POST['requesterName']) && isset($_POST['recipientName']) && isset($_POST['letterContent']) && 
    isset($_POST['adviserName']) && isset($_POST['position'])) {
    
    $requester = htmlspecialchars($_POST['requesterName']);
    $position = htmlspecialchars($_POST['position']);
    $association = htmlspecialchars($_POST['association']);
    $recipient = htmlspecialchars($_POST['recipientName']);
    $adviser = htmlspecialchars($_POST['adviserName']);
    $body = htmlspecialchars($_POST['letterContent']);

    $templateProcessor = new TemplateProcessor('SAMPLE_TEMPLATE.docx');
    $placeholders = $templateProcessor->getVariables();
    echo 'Placeholders found in template: <pre>' . print_r($placeholders, true) . '</pre>';

    $templateProcessor->setValue('Association', $association);
    $templateProcessor->setValue('Recipient', $recipient);
    $templateProcessor->setValue('Requester', $requester);
    $templateProcessor->setValue('Position', $position);
    $templateProcessor->setValue('Adviser', $adviser);

    // Replace new lines with Word's line break symbol
    $formattedMessage = str_replace("\n", '<w:br/>', $body);
    $templateProcessor->setValue('LetterContent', $formattedMessage);

    // Save the document to a temporary file
    $pathToSave = 'document.docx';
    $templateProcessor->saveAs($pathToSave);

    if (file_exists($pathToSave)) {
        // Read the file contents
        $fileContent = file_get_contents($pathToSave);

        $database = new Database();
        $mysqli = $database->getConnection();

        $query = "INSERT INTO documents (name, content) VALUES (?, ?)";
        $fileName = 'haynako.docx';
        $null = NULL;

        $stmt = $mysqli->stmt_init();
        if(!$stmt->prepare($query)){
            die("SQL Error". $mysqli->error);
        }

        $stmt->bind_param("sb", $fileName, $null);

        $stmt->send_long_data(1, $fileContent);
        $stmt->execute();

        $stmt->close();
        $mysqli->close();

        echo "Document saved successfully. <br> <a href='downloadFile.php'>Redirect page to download the letter</a>";
    } else {
        echo "Failed to create document.";
    }
} else {
    echo "Please upload all required files and fill out all fields.";
}
?>
