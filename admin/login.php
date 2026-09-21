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
    <link rel="stylesheet" href="../assets/css/admin.css" />
</head>
<body class="admin-auth-page">
    <main>
        <section class="admin-auth-card" aria-labelledby="admin-login-heading">
            <p class="admin-subtitle">Secure access</p>
            <h1 id="admin-login-heading">Admin login</h1>

            <?php if (!empty($error)): ?>
                <p class="admin-error-message"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form method="POST">
                <div>
                    <label for="admin-username">Email</label>
                    <input id="admin-username" type="email" name="email" placeholder="Enter your email" required />
                </div>

                <div>
                    <label for="admin-password">Password</label>
                    <input id="admin-password" type="password" name="password" placeholder="Enter your password" required />
                </div>

                <label class="remember-row" for="remember-me">
                    <input id="remember-me" type="checkbox" name="remember_me" />
                    Remember me
                </label>

                <button class="login-button" type="submit">Login</button>
            </form>
        </section>
    </main>

    <script src="../assets/js/components.js"></script>
</body>
</html>
