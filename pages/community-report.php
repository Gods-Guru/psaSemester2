<?php

require_once "../includes/database.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $community_name = trim($_POST["community_name"]);
    $location = trim($_POST["location"]);
    $need_type = trim($_POST["need_type"]);
    $description = trim($_POST["situation_description"]);
    $people_affected = !empty($_POST["people_affected"])
        ? (int) $_POST["people_affected"]
        : null;
    $reporter_name = trim($_POST["reporter_name"]);
    $email = trim($_POST["reporter_email"]);
    $phone = trim($_POST["reporter_phone"]);
    $additional_information = trim($_POST["additional_information"]);

    if (
        $community_name === "" ||
        $location === "" ||
        $need_type === "" ||
        $description === "" ||
        $reporter_name === "" ||
        $email === ""
    ) {

        $error = "Please fill in all required fields.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO community_reports
            (
                reporter_name,
                email,
                phone,
                community_name,
                location,
                need_type,
                description,
                people_affected,
                additional_information
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssssssis",
            $reporter_name,
            $email,
            $phone,
            $community_name,
            $location,
            $need_type,
            $description,
            $people_affected,
            $additional_information
        );

        if ($stmt->execute()) {
            $success = "Your community report has been submitted successfully.";
        } else {
            $error = "Something went wrong. Please try again.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Report | My Next Level</title>
    <meta name="description" content="Community report form for My Next Level." />
    <link rel="stylesheet" href="../assets/css/index.css" />
</head>
<body>
    <site-header></site-header>

    <main>
        <section aria-labelledby="community-report-heading">
            <p>Community report</p>
            <h1 id="community-report-heading">Tell us about a community in need.</h1>
            <p>Share details about a family, community or group that may require support and assistance.</p>
        </section>

        <section>
            <form method="POST">
                <label for="community-name">Community name</label>
                <input id="community-name" type="text" name="community_name" placeholder="Community or area name" />

                <label for="community-location">Location</label>
                <input id="community-location" type="text" name="location" placeholder="Community location" required />

                <label for="situation-description">Description of the situation</label>
                <textarea id="situation-description" name="situation_description" rows="5" placeholder="Describe the situation" required></textarea>

                <label for="need-type">Type of need</label>
                <select id="need-type" name="need_type">
                    <option value="">Select a need type</option>
                    <option value="food-support">Food support</option>
                    <option value="education-support">Education support</option>
                    <option value="family-care">Family care</option>
                    <option value="emergency-support">Emergency support</option>
                    <option value="other">Other</option>
                </select>

                <label for="people-affected">Estimated number of people affected</label>
                <input id="people-affected" type="number" name="people_affected" min="1" placeholder="Number of people affected" />

                <label for="reporter-name">Reporter name</label>
                <input id="reporter-name" type="text" name="reporter_name" placeholder="Your name" required />

                <label for="reporter-email">Reporter email</label>
                <input id="reporter-email" type="email" name="reporter_email" placeholder="you@example.com" required />

                <label for="reporter-phone">Reporter phone</label>
                <input id="reporter-phone" type="tel" name="reporter_phone" placeholder="Your phone number" />

                <label for="additional-info">Additional information</label>
                <textarea id="additional-info" name="additional_information" rows="4" placeholder="Any additional details"></textarea>

                <label for="support-image">Optional image upload</label>
                <input id="support-image" type="file" name="support_image" accept="image/*" />

                <button type="submit">Submit community report</button>
                <?php if ($success): ?>
                <div role="status" aria-live="polite">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div role="alert" aria-live="assertive">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            </form>
        </section>
    </main>

    <site-footer></site-footer>
    <script src="../assets/js/components.js"></script>
</body>
</html>
