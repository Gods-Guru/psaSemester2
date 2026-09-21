<?php

require_once "../includes/database.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    if (
        $name === "" ||
        $email === "" ||
        $subject === "" ||
        $message === ""
    ) {

        $error = "Please fill in all required fields.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO contacts
            (name, email, subject, message)
            VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssss",
            $name,
            $email,
            $subject,
            $message
        );

        if ($stmt->execute()) {
            $success = "Your message has been sent successfully.";
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
    <title>Contact | My Next Level</title>
    <meta name="description" content="Contact page for My Next Level." />
    <link rel="stylesheet" href="../assets/css/index.css" />
    <link rel="stylesheet" href="../assets/css/components.css" />
    <link rel="stylesheet" href="../assets/css/responsive.css" />
    <!-- <link rel="stylesheet" href="../assets/css/contact.css" /> -->
</head>
<body class="public-site">
    <site-header></site-header>

    <main class="public-page contact-page">
        <section class="public-hero contact-hero" aria-labelledby="contact-page-heading">
            <p>Contact</p>
            <h1 id="contact-page-heading">Get in touch with My Next Level.</h1>
            <p>Send a message to connect with My Next Level about community support, volunteering, sponsorship or general enquiries.</p>
        </section>

        <section class="public-section contact-information" aria-labelledby="contact-info-heading">
            <h2 id="contact-info-heading">Connect with us</h2>
            <p>Send us a message and we’ll help connect you with the right team, opportunity or support pathway.</p>

            <div class="public-card-grid">
                <article class="public-card">
                    <h3>Email</h3>
                    <p>hello@mynextlevel.org</p>
                </article>

                <article class="public-card">
                    <h3>Phone</h3>
                    <p>+234(0)12345678</p>
                </article>

                <article class="public-card">
                    <h3>Location</h3>
                    <p>Community outreach offices across Nigeria</p>
                </article>
            </div>
        </section>

        <section class="public-form-section contact-form-section" aria-labelledby="contact-form-heading">
            <h2 id="contact-form-heading">Send a message</h2>
            <div class="public-form-wrapper">
                <form class="public-form contact-form" method="POST">
                    <div class="contact-form-section-group">
                        <h3>Your details</h3>
                        <div class="public-form-grid">
                            <div class="public-form-field">
                                <label for="contact-name">Name</label>
                                <input id="contact-name" type="text" name="name" placeholder="Your name" required />
                            </div>

                            <div class="public-form-field">
                                <label for="contact-email">Email</label>
                                <input id="contact-email" type="email" name="email" placeholder="you@example.com" required />
                            </div>
                        </div>
                    </div>

                    <div class="contact-form-section-group">
                        <h3>Your message</h3>
                        <div class="public-form-grid">
                            <div class="public-form-field public-form-field-full">
                                <label for="contact-subject">Subject</label>
                                <input id="contact-subject" type="text" name="subject" placeholder="Subject" required />
                            </div>

                            <div class="public-form-field public-form-field-full">
                                <label for="contact-message">Message</label>
                                <textarea id="contact-message" name="message" rows="6" placeholder="Your message" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="contact-form-actions">
                        <button type="submit">Send message</button>
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
