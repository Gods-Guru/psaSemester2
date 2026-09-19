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
            <form>
                <label for="volunteer-name">Full name</label>
                <input id="volunteer-name" type="text" name="full_name" placeholder="Your full name" required />

                <label for="volunteer-email">Email</label>
                <input id="volunteer-email" type="email" name="email" placeholder="you@example.com" required />

                <label for="volunteer-phone">Phone</label>
                <input id="volunteer-phone" type="tel" name="phone" placeholder="Your phone number" required />

                <label for="programme-interest">Programme interested in</label>
                <select id="programme-interest" name="programme_interest">
                    <option value="">Select a programme</option>
                    <option value="programme-one">Programme One</option>
                    <option value="programme-two">Programme Two</option>
                    <option value="programme-three">Programme Three</option>
                    <option value="other">Other</option>
                </select>

                <label for="skills">Skills or interests</label>
                <textarea id="skills" name="skills" rows="4" placeholder="Tell us about your skills or interests"></textarea>

                <label for="availability">Availability</label>
                <input id="availability" type="text" name="availability" placeholder="Weekdays, weekends, evenings, etc." />

                <label for="volunteer-message">Message</label>
                <textarea id="volunteer-message" name="message" rows="5" placeholder="Why do you want to volunteer?" required></textarea>

                <button type="submit">Submit volunteer application</button>
                <div role="status" aria-live="polite">[Success message container]</div>
                <div role="alert" aria-live="assertive">[Error message container]</div>
            </form>
        </section>
    </main>

    <site-footer></site-footer>
    <script src="../assets/js/components.js"></script>
</body>
</html>
