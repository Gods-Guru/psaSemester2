<?php

require_once "../includes/database.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"]);
    $organisation = trim($_POST["organisation"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $sponsorship_type = trim($_POST["sponsorship_type"]);
    $message = trim($_POST["message"]);

    if ($full_name === "" || $email === "" || $message === "") {

        $error = "Please fill in all required fields.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO sponsors
            (full_name, organisation, email, phone, sponsorship_type, message)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssssss",
            $full_name,
            $organisation,
            $email,
            $phone,
            $sponsorship_type,
            $message
        );

        if ($stmt->execute()) {
            $success = "Your sponsorship enquiry has been submitted successfully.";
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
    <title>Sponsor | My Next Level</title>
    <meta name="description" content="Sponsorship page for My Next Level." />
    <link rel="stylesheet" href="../assets/css/index.css" />
</head>
<body>
    <site-header></site-header>

    <main>
        <section aria-labelledby="sponsor-page-heading">
            <p>Sponsor</p>
            <h1 id="sponsor-page-heading">Support My Next Level as a valued partner.</h1>
            <p>[Sponsorship introduction placeholder.]</p>
        </section>

        <section aria-labelledby="why-sponsor-heading">
            <h2 id="why-sponsor-heading">Why sponsor My Next Level?</h2>
            <p>[Explanation of the impact sponsorship can have on community programmes and support services.]</p>
        </section>

        <section aria-labelledby="sponsor-info-heading">
            <h2 id="sponsor-info-heading">Sponsorship information</h2>
            <ul>
                <li>[Sponsorship type placeholder]</li>
                <li>[Programme support placeholder]</li>
                <li>[Community outreach placeholder]</li>
            </ul>
        </section>

        <section aria-labelledby="sponsor-form-heading">
            <h2 id="sponsor-form-heading">Sponsor enquiry form</h2>
            <form method="POST">
                <label for="sponsor-name">Full name</label>
                <input id="sponsor-name" type="text" name="full_name" placeholder="Your full name" required />

                <label for="organisation-name">Organisation name</label>
                <input id="organisation-name" type="text" name="organisation" placeholder="Your organisation name" />

                <label for="sponsor-email">Email</label>
                <input id="sponsor-email" type="email" name="email" placeholder="you@example.com" required />

                <label for="sponsor-phone">Phone</label>
                <input id="sponsor-phone" type="tel" name="phone" placeholder="Your phone number" />

                <label for="sponsorship-interest">Sponsorship interest or type</label>
                <select id="sponsorship-interest" name="sponsorship_type">
                    <option value="">Select sponsorship interest</option>
                    <option value="programme-support">Programme support</option>
                    <option value="community-outreach">Community outreach</option>
                    <option value="event-sponsorship">Event sponsorship</option>
                    <option value="general-support">General support</option>
                </select>

                <label for="sponsor-message">Message</label>
                <textarea id="sponsor-message" name="message" rows="5" placeholder="Tell us about your sponsorship interest" required></textarea>

                <button type="submit">Submit enquiry</button>
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
