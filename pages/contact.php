<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | My Next Level</title>
    <meta name="description" content="Contact page for My Next Level." />
    <link rel="stylesheet" href="../assets/css/index.css" />
</head>
<body>
    <site-header></site-header>

    <main>
        <section aria-labelledby="contact-page-heading">
            <p>Contact</p>
            <h1 id="contact-page-heading">Get in touch with My Next Level.</h1>
            <p>[Contact introduction placeholder.]</p>
        </section>

        <section aria-labelledby="contact-info-heading">
            <h2 id="contact-info-heading">Contact information</h2>
            <ul>
                <li>Email: [email placeholder]</li>
                <li>Phone: [phone placeholder]</li>
                <li>Address: [address placeholder]</li>
                <li>Social media: [social placeholder]</li>
            </ul>
        </section>

        <section aria-labelledby="contact-form-heading">
            <h2 id="contact-form-heading">Send a message</h2>
            <form>
                <label for="contact-name">Name</label>
                <input id="contact-name" type="text" name="name" placeholder="Your name" required />

                <label for="contact-email">Email</label>
                <input id="contact-email" type="email" name="email" placeholder="you@example.com" required />

                <label for="contact-subject">Subject</label>
                <input id="contact-subject" type="text" name="subject" placeholder="Subject" required />

                <label for="contact-message">Message</label>
                <textarea id="contact-message" name="message" rows="5" placeholder="Your message" required></textarea>

                <button type="submit">Send message</button>
                <div role="status" aria-live="polite">[Success message container]</div>
                <div role="alert" aria-live="assertive">[Error message container]</div>
            </form>
        </section>
    </main>

    <site-footer></site-footer>
    <script src="../assets/js/components.js"></script>
</body>
</html>
