<?php

session_start();

require_once "../includes/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin["password"])) {

            $_SESSION["admin_id"] = $admin["id"];
            $_SESSION["admin_name"] = $admin["name"];

            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Invalid email or password.";
        }

    } else {
        $error = "Invalid email or password.";
    }
}

?>

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
        <?php if (!empty($error)): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <section aria-labelledby="admin-login-heading">
            <h1 id="admin-login-heading">Admin login</h1>
            <form method="POST">
                <label for="admin-username">Email: </label>
                <input id="admin-username" type="email" name="email" placeholder="Enter your email" required />

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
