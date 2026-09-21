<?php

require_once "../includes/auth.php";
require_once "../includes/database.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid programme ID.");
}

$id = (int) $_GET["id"];

$message = "";
$error = "";

// Update programme
if (isset($_POST["update_program"])) {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $location = trim($_POST["location"]);
    $program_date = $_POST["program_date"];
    $status = $_POST["status"];

    if ($title === "" || $description === "" || $program_date === "") {

        $error = "Please fill in all required fields.";

    } else {

        $stmt = $conn->prepare(
            "UPDATE programs
             SET title = ?, description = ?, location = ?, program_date = ?, status = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "sssssi",
            $title,
            $description,
            $location,
            $program_date,
            $status,
            $id
        );

        if ($stmt->execute()) {
            $message = "Programme updated successfully.";
        } else {
            $error = "Failed to update programme.";
        }

        $stmt->close();
    }
}

// Get programme
$stmt = $conn->prepare("SELECT * FROM programs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Programme not found.");
}

$program = $result->fetch_assoc();

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Programme | My Next Level</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body class="admin-programs">

    <div class="admin-layout">
        <?php require_once "admin-navigation.php"; ?>

        <main class="admin-main">

    <h1>Edit Programme</h1>

    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">

        <div>
            <label for="title">Title</label>
            <input
                type="text"
                id="title"
                name="title"
                value="<?php echo htmlspecialchars($program["title"]); ?>"
                required
            >
        </div>

        <div>
            <label for="description">Description</label>
            <textarea
                id="description"
                name="description"
                required
            ><?php echo htmlspecialchars($program["description"]); ?></textarea>
        </div>

        <div>
            <label for="location">Location</label>
            <input
                type="text"
                id="location"
                name="location"
                value="<?php echo htmlspecialchars($program["location"] ?? ""); ?>"
            >
        </div>

        <div>
            <label for="program_date">Programme Date</label>
            <input
                type="date"
                id="program_date"
                name="program_date"
                value="<?php echo htmlspecialchars($program["program_date"]); ?>"
                required
            >
        </div>

        <div>
            <label for="status">Status</label>
            <select id="status" name="status">

                <option value="upcoming"
                    <?php echo $program["status"] === "upcoming" ? "selected" : ""; ?>>
                    Upcoming
                </option>

                <option value="ongoing"
                    <?php echo $program["status"] === "ongoing" ? "selected" : ""; ?>>
                    Ongoing
                </option>

                <option value="completed"
                    <?php echo $program["status"] === "completed" ? "selected" : ""; ?>>
                    Completed
                </option>

            </select>
        </div>

        <button type="submit" name="update_program">
            Update Programme
        </button>

    </form>

    <p>
        <a href="programs.php">Back to Programmes</a>
    </p>

        </main>
    </div>

</body>
</html>