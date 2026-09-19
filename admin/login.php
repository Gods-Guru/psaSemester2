<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | My Next Level</title>
    <meta name="description" content="Admin login page for My Next Level." />
    <link rel="stylesheet" href="../assets/css/index.css" />
</head>
<body>
    <site-header></site-header>

    <main>
        <section aria-labelledby="admin-login-heading">
            <h1 id="admin-login-heading">Admin login</h1>
            <form>
                <label for="admin-username">Email or username</label>
                <input id="admin-username" type="text" name="username" placeholder="Enter your email or username" required />

                <label for="admin-password">Password</label>
                <input id="admin-password" type="password" name="password" placeholder="Enter your password" required />

                <label for="remember-me">
                    <input id="remember-me" type="checkbox" name="remember_me" />
                    Remember me
                </label>

                <button type="submit">Login</button>
                <div role="alert" aria-live="assertive">[Error message container]</div>
            </form>
        </section>
    </main>

    <site-footer></site-footer>
    <script src="../assets/js/components.js"></script>
</body>
</html>
