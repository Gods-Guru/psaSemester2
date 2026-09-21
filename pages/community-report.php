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
    <link rel="stylesheet" href="../assets/css/community-report.css" />
    <link rel="stylesheet" href="../assets/css/components.css" />
    <link rel="stylesheet" href="../assets/css/responsive.css" />
</head>
<body class="public-site">
    <site-header></site-header>

    <main class="public-page community-report-page">
        <section class="public-hero community-report-hero" aria-labelledby="community-report-heading">
            <p>Community report</p>
            <h1 id="community-report-heading">Tell us about a community in need.</h1>
            <p>Share details about a family, community or group that may require support and assistance.</p>
        </section>

        <section class="community-report-form-section" aria-labelledby="report-form-heading">
            <div class="community-report-form-wrapper">
                <h2 id="report-form-heading">Community information</h2>

                <form class="community-report-form" method="POST">
                    <div class="form-section community-report-community-section">
                        <h3>Community information</h3>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="community-name">Community name</label>
                                <input id="community-name" type="text" name="community_name" placeholder="Community or area name" required />
                            </div>

                            <div class="form-field">
                                <label for="community-location">Location</label>
                                <input id="community-location" type="text" name="location" placeholder="Community location" required />
                            </div>

                            <div class="form-field">
                                <label for="need-type">Type of need</label>
                                <select id="need-type" name="need_type" required>
                                    <option value="">Select a need type</option>
                                    <option value="food-support">Food support</option>
                                    <option value="education-support">Education support</option>
                                    <option value="family-care">Family care</option>
                                    <option value="emergency-support">Emergency support</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="form-field">
                                <label for="people-affected">Estimated number of people affected</label>
                                <input id="people-affected" type="number" name="people_affected" min="1" placeholder="Number of people affected" />
                            </div>
                        </div>
                    </div>

                    <div class="form-section community-report-situation-section">
                        <h3>Situation</h3>
                        <div class="form-grid">
                            <div class="form-field form-field-full">
                                <label for="situation-description">Description of the situation</label>
                                <textarea id="situation-description" name="situation_description" rows="6" placeholder="Describe the situation" required></textarea>
                            </div>

                            <div class="form-field form-field-full">
                                <label for="additional-info">Additional information</label>
                                <textarea id="additional-info" name="additional_information" rows="4" placeholder="Any additional details"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-section community-report-reporter-section">
                        <h3>Reporter information</h3>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="reporter-name">Reporter name</label>
                                <input id="reporter-name" type="text" name="reporter_name" placeholder="Your name" required />
                            </div>

                            <div class="form-field">
                                <label for="reporter-email">Reporter email</label>
                                <input id="reporter-email" type="email" name="reporter_email" placeholder="you@example.com" required />
                            </div>

                            <div class="form-field">
                                <label for="reporter-phone">Reporter phone</label>
                                <input id="reporter-phone" type="tel" name="reporter_phone" placeholder="Your phone number" />
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit">Submit community report</button>
                    </div>

                    <?php if ($success): ?>
                        <div class="community-report-message community-report-success" role="status" aria-live="polite">
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="community-report-message community-report-error" role="alert" aria-live="assertive">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
            </form>
            </div>
        </section>
    </main>

    <site-footer></site-footer>
    <script src="../assets/js/components.js"></script>
</body>
</html>
