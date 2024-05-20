<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="GenerateLetter.php" method="POST" enctype="multipart/form-data">

        <label for="association">Association Name:</label>
        <input name="association" id="association" required></input><br><br>

        <label for="requesterName">Requester Name:</label>
        <input name="requesterName" id="requesterName" required></input><br><br>

        <label for="position">Requester Position:</label>
        <input name="position" id="position" required></input><br><br>

        <label for="recipientName">Recipient Name:</label>
        <input type="text" name="recipientName" id="recipientName" required><br><br>

        <label for="adviser">Adviser Name:</label>
        <input name="adviserName" id="adviser" required></input><br><br>

        <label for="letterContent">Letter Content:</label><br>
        <textarea name="letterContent" id="letterContent" rows="10" cols="50" required></textarea><br><br>

        <button type="submit">Generate Letter</button>
    </form>
</body>
</html>