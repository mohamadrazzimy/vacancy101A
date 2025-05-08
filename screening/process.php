<?php
require '../vacancy/config.php';
require '../screening/sendmail.php'; // Include the sendmail.php script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $applicant_name = isset($_POST['applicant_name']) ? htmlspecialchars(trim($_POST['applicant_name'])) : '';
    $applicant_email = isset($_POST['applicant_email']) ? filter_var($_POST['applicant_email'], FILTER_VALIDATE_EMAIL) : '';
    $applicant_mobile_no = isset($_POST['applicant_mobile_no']) ? htmlspecialchars(trim($_POST['applicant_mobile_no'])) : '';
    $interview_date = isset($_POST['interview_date']) ? htmlspecialchars(trim($_POST['interview_date'])) : '';
    $applicant_resume = isset($_POST['applicant_resume']) ? trim($_POST['applicant_resume']) : ''; // Get resume data

    // Check for valid input
    if (empty($applicant_name)) {
        echo "Error: Applicant name is required.";
        exit;
    }

    if ($applicant_email === false) {
        echo "Error: Invalid applicant email.";
        exit;
    }

    if (empty($interview_date)) {
        echo "Error: Interview date is required.";
        exit;
    }

    try {
        // Insert data into the candidates table
        // Include the resume data in the INSERT statement
        $sql = "INSERT INTO candidates (name, email, mobile_no, interview_date, resume) VALUES (:name, :email, :mobile_no, :interview_date, :resume)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $applicant_name);
        $stmt->bindParam(':email', $applicant_email);
        $stmt->bindParam(':mobile_no', $applicant_mobile_no);
        $stmt->bindParam(':interview_date', $interview_date);
        $stmt->bindParam(':resume', $applicant_resume); // Bind the resume data
        $stmt->execute();

        // Get the ID of the last inserted row
        $candidateId = $pdo->lastInsertId();

        // Email parameters
        $to = $applicant_email;
        $name = $applicant_name;
        $subject = 'Interview Scheduled';
        $body = "Dear " . htmlspecialchars($applicant_name) . ",<br><br>You have been scheduled for an interview on " . htmlspecialchars($interview_date) . ".";
        $altBody = "Dear " . htmlspecialchars($applicant_name) . ",\n\nYou have been scheduled for an interview on " . htmlspecialchars($interview_date) . ".";

        // Send email using the sendEmail function
        if (sendEmail($to, $name, $subject, $body, $altBody)) {
            echo 'Message has been sent to: ' . htmlspecialchars($applicant_email) . ' and candidate added with ID: ' . $candidateId;
        } else {
            echo 'Message could not be sent to: ' . htmlspecialchars($applicant_email) . ' but candidate added with ID: ' . $candidateId;
        }



    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>