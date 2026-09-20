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
</head>
<body>
    <site-header></site-header>

    <main>
        <section aria-labelledby="volunteer-page-heading">
            <p>Volunteer</p>
            <h1 id="volunteer-page-heading">Apply to become a volunteer.</h1>
            <p>We welcome support from people who want to contribute time, skills and care to underserved communities.</p>
        </section>

        <section>
            <form method="POST">
                <label for="volunteer-name">Full name</label>
                <input id="volunteer-name" type="text" name="full_name" placeholder="Your full name" required />

                <label for="volunteer-email">Email</label>
                <input id="volunteer-email" type="email" name="email" placeholder="you@example.com" required />

                <label for="volunteer-phone">Phone</label>
                <input id="volunteer-phone" type="tel" name="phone" placeholder="Your phone number" required />

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

                <label for="skills">Skills or interests</label>
                <textarea id="skills" name="skills" rows="4" placeholder="Tell us about your skills or interests"></textarea>

                <label for="availability">Availability</label>
                <input id="availability" type="text" name="availability" placeholder="Weekdays, weekends, evenings, etc." />

                <label for="volunteer-message">Message</label>
                <textarea id="volunteer-message" name="message" rows="5" placeholder="Why do you want to volunteer?" required></textarea>

                <button type="submit">Submit volunteer application</button>
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
