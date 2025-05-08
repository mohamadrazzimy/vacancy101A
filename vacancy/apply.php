<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Apply for Vacancy</title>
</head>
<body>
    <h1>Vacancy Application Form</h1>
    <form action="process.php" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="mobile_no">Mobile Number:</label>
        <input type="text" id="mobile_no" name="mobile_no" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="resume">Resume (PDF only):</label>
        <input type="file" id="resume" name="resume" accept=".pdf" required>
        <br>
        <label for="summary">Summary:</label>
        <textarea id="summary" name="summary" rows="4" cols="50"></textarea>  <!-- ADDED SUMMARY FIELD -->
        <br>
        <input type="submit" value="Submit Application">
    </form>
</body>
</html>