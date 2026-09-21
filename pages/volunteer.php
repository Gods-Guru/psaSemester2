<?php

require_once "../includes/database.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $program_id = !empty($_POST["program_id"]) ? (int) $_POST["program_id"] : null;
    $skills = trim($_POST["skills"]);
    $availability = trim($_POST["availability"]);
    $message = trim($_POST["message"]);

    if ($full_name === "" || $email === "" || $phone === "" || $message === "") {

        $error = "Please fill in all required fields.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO volunteers
            (full_name, email, phone, program_id, skills, availability, message)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssisss",
            $full_name,
            $email,
            $phone,
            $program_id,
            $skills,
            $availability,
            $message
        );

        if ($stmt->execute()) {
            $success = "Your volunteer application has been submitted successfully.";
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
    <title>Volunteer | My Next Level</title>
    <meta name="description" content="Volunteer application form for My Next Level." />
    <link rel="stylesheet" href="../assets/css/index.css" />
    <link rel="stylesheet" href="../assets/css/volunteer.css" />
    <link rel="stylesheet" href="../assets/css/components.css" />
    <link rel="stylesheet" href="../assets/css/responsive.css" />
</head>
<body class="public-site">
    <site-header></site-header>

    <main class="public-page volunteer-page">
        <section class="public-hero volunteer-hero" aria-labelledby="volunteer-page-heading">
            <p>Volunteer</p>
            <h1 id="volunteer-page-heading">Apply to become a volunteer.</h1>
            <p>We welcome support from people who want to contribute time, skills and care to underserved communities.</p>
        </section>

        <section class="public-form-section volunteer-form-section" aria-labelledby="volunteer-form-heading">
            <h2 id="volunteer-form-heading">Volunteer application</h2>
            <div class="public-form-wrapper">
            <form class="public-form volunteer-form" method="POST">
                <div class="public-form-grid">
                    <div class="public-form-field">
                        <label for="volunteer-name">Full name</label>
                        <input id="volunteer-name" type="text" name="full_name" placeholder="Your full name" required />
                    </div>

                    <div class="public-form-field">
                        <label for="volunteer-email">Email</label>
                        <input id="volunteer-email" type="email" name="email" placeholder="you@example.com" required />
                    </div>

                    <div class="public-form-field">
                        <label for="volunteer-phone">Phone</label>
                        <input id="volunteer-phone" type="tel" name="phone" placeholder="Your phone number" required />
                    </div>

                    <div class="public-form-field">
                        <label for="programme-interest">Programme interested in</label>
                        <select id="programme-interest" name="program_id">
                            <option value="">Select a programme</option>

                            <?php
                            $program_result = $conn->query(
                                "SELECT id, title FROM programs ORDER BY program_date ASC"
                            );
                            ?>

                            <?php if ($program_result && $program_result->num_rows > 0): ?>
                                <?php while ($program = $program_result->fetch_assoc()): ?>
                                    <option value="<?php echo $program["id"]; ?>">
                                        <?php echo htmlspecialchars($program["title"]); ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="public-form-field public-form-field-full">
                        <label for="skills">Skills or interests</label>
                        <textarea id="skills" name="skills" rows="4" placeholder="Tell us about your skills or interests"></textarea>
                    </div>

                    <div class="public-form-field public-form-field-full">
                        <label for="availability">Availability</label>
                        <input id="availability" type="text" name="availability" placeholder="Weekdays, weekends, evenings, etc." />
                    </div>

                    <div class="public-form-field public-form-field-full">
                        <label for="volunteer-message">Message</label>
                        <textarea id="volunteer-message" name="message" rows="5" placeholder="Why do you want to volunteer?" required></textarea>
                    </div>
                </div>

                <div class="public-actions">
                    <button type="submit">Submit volunteer application</button>
                </div>

                <?php if ($success): ?>
                    <div class="public-message public-success" role="status" aria-live="polite">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="public-message public-error" role="alert" aria-live="assertive">
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
