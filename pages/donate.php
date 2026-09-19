<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate | My Next Level</title>
    <meta name="description" content="Donation page for My Next Level." />
    <link rel="stylesheet" href="../assets/css/index.css" />
</head>
<body>
    <site-header></site-header>

    <main>
        <section aria-labelledby="donate-page-heading">
            <p>Donate</p>
            <h1 id="donate-page-heading">Support My Next Level.</h1>
            <p>Your contribution can help fund community support, programmes and outreach needs.</p>
        </section>

        <section aria-labelledby="donate-reasons-heading">
            <h2 id="donate-reasons-heading">Why donations matter</h2>
            <p>[Explanation of how donations support community care and programme delivery.]</p>
        </section>

        <section aria-labelledby="donation-options-heading">
            <h2 id="donation-options-heading">Choose a donation amount</h2>
            <form>
                <fieldset>
                    <legend>Donation amount</legend>
                    <label><input type="radio" name="amount" value="50" /> RM 50</label>
                    <label><input type="radio" name="amount" value="100" /> RM 100</label>
                    <label><input type="radio" name="amount" value="250" /> RM 250</label>
                    <label><input type="radio" name="amount" value="500" /> RM 500</label>
                    <label><input type="radio" name="amount" value="custom" /> Custom amount</label>
                </fieldset>

                <label for="custom-amount">Custom donation amount</label>
                <input id="custom-amount" type="number" name="custom_amount" min="1" placeholder="Enter amount" />

                <label for="donor-name">Full name</label>
                <input id="donor-name" type="text" name="donor_name" placeholder="Your full name" required />

                <label for="donor-email">Email</label>
                <input id="donor-email" type="email" name="donor_email" placeholder="you@example.com" required />

                <label for="donor-phone">Phone</label>
                <input id="donor-phone" type="tel" name="donor_phone" placeholder="Your phone number" />

                <label for="donation-purpose">Donation purpose</label>
                <input id="donation-purpose" type="text" name="donation_purpose" placeholder="General fund / programme / community support" />

                <label for="donation-message">Optional message</label>
                <textarea id="donation-message" name="donation_message" rows="4" placeholder="Add an optional message"></textarea>

                <fieldset>
                    <legend>Payment section placeholder</legend>
                    <p>[Payment gateway details to be added later.]</p>
                </fieldset>

                <button type="submit">Donate now</button>
                <div role="status" aria-live="polite">[Success message container]</div>
                <div role="alert" aria-live="assertive">[Error message container]</div>
            </form>
        </section>
    </main>

    <site-footer></site-footer>
    <script src="../assets/js/components.js"></script>
</body>
</html>
