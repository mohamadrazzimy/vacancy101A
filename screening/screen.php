<?php
require '../vacancy/config.php'; // Adjust path if needed

try {
    // Query to select all records from the applications table, including the summary and resume
    $stmt = $pdo->query("SELECT id, name, email, mobile_no, summary, resume FROM applications"); // Added resume
    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screen Applications</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to style.css -->
</head>
<body>
    <div class="container">
        <h1>Application Screening</h1> <!-- Main Heading -->
        <h2>Select Application for Screening</h2>

        <?php foreach ($applications as $application): ?>
            <div class="application-record">
                <p><strong>ID:</strong> <?= htmlspecialchars($application['id']) ?></p>
                <p><strong>Name:</strong> <?= htmlspecialchars($application['name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($application['email']) ?></p>
                <p><strong>Mobile No:</strong> <?= htmlspecialchars($application['mobile_no']) ?></p>
                <p><strong>Summary:</strong> <?= htmlspecialchars($application['summary']) ?></p>
                <p><strong>Resume:</strong> <?= htmlspecialchars($application['resume']) ?></p> <!-- Display resume -->

                <form action="process.php" method="POST">
                    <input type="hidden" name="application_id" value="<?= htmlspecialchars($application['id']) ?>">
                    <input type="hidden" name="applicant_name" value="<?= htmlspecialchars($application['name']) ?>">
                    <input type="hidden" name="applicant_email" value="<?= htmlspecialchars($application['email']) ?>">
                    <input type="hidden" name="applicant_mobile_no" value="<?= htmlspecialchars($application['mobile_no']) ?>">
                    <input type="hidden" name="applicant_resume" value="<?= htmlspecialchars($application['resume']) ?>"> <!-- Pass resume to process.php -->
                    <label for="interview_date">Interview Date and Time:</label>
                    <input type="datetime-local" id="interview_date" name="interview_date" required>
                    <button type="submit">Process</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>