<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $mobile_no = $_POST['mobile_no'];
    $email = $_POST['email'];
    $summary = $_POST['summary']; // ADDED SUMMARY

    // File upload handling
    $targetDir = "../../uploads/";
    $resumeFile = $_FILES['resume'];
    $targetFile = $targetDir . basename($resumeFile["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validate file type
    if ($fileType != "pdf") {
        echo "<div class='message error'>Sorry, only PDF files are allowed.</div>";
        $uploadOk = 0;
    }

    // Check if upload is ok
    if ($uploadOk == 1) {
        if (move_uploaded_file($resumeFile["tmp_name"], $targetFile)) {
            // Insert application details into the database
            $stmt = $pdo->prepare("INSERT INTO applications (name, mobile_no, email, resume, summary) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $mobile_no, $email, $targetFile, $summary]); 

            echo "<link rel='stylesheet' type='text/css' href='style.css'>";
            echo "<div class='message success'><h1>Application Submitted Successfully!</h1></div>";
            echo "<a class='button' href='index.php'>Back to Home</a>";
        } else {
            echo "<link rel='stylesheet' type='text/css' href='style.css'>";
            echo "<div class='message error'>Sorry, there was an error uploading your file.</div>";
        }
    } else {
        echo "<link rel='stylesheet' type='text/css' href='style.css'>";
        echo "<div class='message error'>Your file was not uploaded.</div>";
    }
} else {
    header("Location: index.php");
    exit();
}
?>