<?php

require_once "../includes/database.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $amount_option = $_POST["amount"] ?? "";
    $custom_amount = $_POST["custom_amount"] ?? "";

    $donor_name = trim($_POST["donor_name"] ?? "");
    $donor_email = trim($_POST["donor_email"] ?? "");
    $donor_phone = trim($_POST["donor_phone"] ?? "");
    $donation_message = trim($_POST["donation_message"] ?? "");

    // Determine the donation amount
    if ($amount_option === "custom") {
        $amount = (float) $custom_amount;
    } else {
        $amount = (float) $amount_option;
    }

    if (
        $donor_name === "" ||
        $donor_email === "" ||
        $amount <= 0
    ) {

        $error = "Please provide your name, email and a valid donation amount.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO donations
            (donor_name, email, phone, amount, message)
            VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssds",
            $donor_name,
            $donor_email,
            $donor_phone,
            $amount,
            $donation_message
        );

        if ($stmt->execute()) {
            $success = "Your donation has been recorded successfully. Payment processing will be added later.";
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
    <title>Donate | My Next Level</title>
    <meta name="description" content="Donation page for My Next Level." />
    <link rel="stylesheet" href="../assets/css/index.css" />
    <link rel="stylesheet" href="../assets/css/donate.css" />
    <link rel="stylesheet" href="../assets/css/components.css" />
    <link rel="stylesheet" href="../assets/css/responsive.css" />
</head>
<body class="public-site">
    <site-header></site-header>

    <main class="public-page donate-page">
        <section class="public-hero donate-hero" aria-labelledby="donate-page-heading">
            <p>Donate</p>
            <h1 id="donate-page-heading">Support My Next Level.</h1>
            <p>Your contribution can help fund community support, programmes and outreach needs.</p>
        </section>

        <section class="public-section public-card donate-reasons" aria-labelledby="donate-reasons-heading">
            <h2 id="donate-reasons-heading">Why donations matter</h2>
            <p>[Explanation of how donations support community care and programme delivery.]</p>
        </section>

        <section class="public-form-section donate-form-section" aria-labelledby="donation-options-heading">
            <h2 id="donation-options-heading">Choose a donation amount</h2>
            <div class="public-form-wrapper">
            <form class="public-form donate-form" method="POST">
                <fieldset>
                    <legend>Donation amount</legend>
                    <div class="public-form-grid">
                        <label class="public-form-option"><input type="radio" name="amount" value="50" /> ₦50k</label>
                        <label class="public-form-option"><input type="radio" name="amount" value="100" /> ₦100k</label>
                        <label class="public-form-option"><input type="radio" name="amount" value="250" /> ₦250k</label>
                        <label class="public-form-option"><input type="radio" name="amount" value="500" /> ₦500k</label>
                        <label class="public-form-option public-form-field-full"><input type="radio" name="amount" value="custom" /> Custom amount</label>
                    </div>
                </fieldset>

                <div class="public-form-grid">
                    <div class="public-form-field public-form-field-full">
                        <label for="custom-amount">Custom donation amount</label>
                        <input id="custom-amount" type="number" name="custom_amount" min="1" placeholder="Enter amount" />
                    </div>

                    <div class="public-form-field">
                        <label for="donor-name">Full name</label>
                        <input id="donor-name" type="text" name="donor_name" placeholder="Your full name" required />
                    </div>

                    <div class="public-form-field">
                        <label for="donor-email">Email</label>
                        <input id="donor-email" type="email" name="donor_email" placeholder="you@example.com" required />
                    </div>

                    <div class="public-form-field">
                        <label for="donor-phone">Phone</label>
                        <input id="donor-phone" type="tel" name="donor_phone" placeholder="Your phone number" />
                    </div>

                    <div class="public-form-field public-form-field-full">
                        <label for="donation-purpose">Donation purpose</label>
                        <input id="donation-purpose" type="text" name="donation_purpose" placeholder="General fund / programme / community support" />
                    </div>

                    <div class="public-form-field public-form-field-full">
                        <label for="donation-message">Optional message</label>
                        <textarea id="donation-message" name="donation_message" rows="4" placeholder="Add an optional message"></textarea>
                    </div>
                </div>

                <fieldset>
                    <legend>Payment details</legend>
                    <p>Payment gateway details will be added later for secure processing.</p>
                </fieldset>

                <div class="public-actions">
                    <button type="submit">Donate now</button>
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
