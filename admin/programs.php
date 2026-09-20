<?php

require_once "../includes/auth.php";
require_once "../includes/database.php";

$message = "";
$error = "";

if (isset($_POST["delete_program"])) {

    $delete_id = (int) $_POST["delete_id"];

    $stmt = $conn->prepare("DELETE FROM programs WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $message = "Programme deleted successfully.";
    } else {
        $error = "Failed to delete programme.";
    }

    $stmt->close();
}

// DELETE PROGRAM
if (isset($_POST["delete_program"])) {

    $delete_id = (int) $_POST["delete_id"];

    $stmt = $conn->prepare("DELETE FROM programs WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $message = "Programme deleted successfully.";
    } else {
        $error = "Failed to delete programme.";
    }

    $stmt->close();
}


// CREATE PROGRAM
if (isset($_POST["add_program"])) {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $location = trim($_POST["location"]);
    $program_date = $_POST["program_date"];
    $status = $_POST["status"];

    if ($title === "" || $description === "" || $program_date === "") {

        $error = "Please fill in all required fields.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO programs (title, description, location, program_date, status)
             VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssss",
            $title,
            $description,
            $location,
            $program_date,
            $status
        );

        if ($stmt->execute()) {
            $message = "Programme added successfully.";
        } else {
            $error = "Failed to add programme.";
        }

        $stmt->close();
    }
}

$sql = "SELECT * FROM programs ORDER BY program_date ASC";
$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programmes | My Next Level</title>
    <meta name="description" content="Programmes and initiatives at My Next Level." />
    <link rel="stylesheet" href="../assets/css/index.css" />
</head>
<body>
    <site-header></site-header>

    <main>
        <section aria-labelledby="programmes-page-heading">
            <p>Programmes</p>
            <h1 id="programmes-page-heading">Current programme areas and initiatives.</h1>
            <p>[Programme overview placeholder text for the organisation.]</p>
        </section>

        <section aria-labelledby="add-program-heading">

            <h2 id="add-program-heading">Add Programme</h2>

            <?php if ($message): ?>
                <p><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>

            <?php if ($error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form method="POST">

                <div>
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div>
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required></textarea>
                </div>

                <div>
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location">
                </div>

                <div>
                    <label for="program_date">Programme Date</label>
                    <input type="date" id="program_date" name="program_date" required>
                </div>

                <div>
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="upcoming">Upcoming</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <button type="submit" name="add_program">Add Programme</button>

            </form>

        </section>

        <section class="programs-list" aria-label="Programme list">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($program = $result->fetch_assoc()): ?>
                    <article class="program-card">
                        <?php if (!empty($program['image'])): ?>
                            <img src="../assets/images/<?php echo htmlspecialchars($program['image']); ?>"
                                 alt="<?php echo htmlspecialchars($program['title']); ?>" />
                        <?php endif; ?>

                        <div class="program-card-content">

                            <h2><?php echo htmlspecialchars($program['title']); ?></h2>

                            <p><?php echo htmlspecialchars($program['description']); ?></p>

                            <?php if (!empty($program['status'])): ?>
                                <p>
                                    <strong>Status:</strong>
                                    <?php echo htmlspecialchars($program['status']); ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($program['location'])): ?>
                                <p>
                                    <strong>Location:</strong>
                                    <?php echo htmlspecialchars($program['location']); ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($program['program_date'])): ?>
                                <p>
                                    <strong>Date:</strong>
                                    <?php echo htmlspecialchars($program['program_date']); ?>
                                </p>
                            <?php endif; ?>

                            <div>
                                <a href="edit-program.php?id=<?php echo $program['id']; ?>">
                                    Edit
                                </a>

                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $program['id']; ?>">
                                    <button type="submit" name="delete_program">
                                        Delete
                                    </button>
                                </form>
                            </div>

                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No programs available at the moment.</p>
            <?php endif; ?>
        </section>
    </main>

    <site-footer></site-footer>
    <script src="../assets/js/components.js"></script>
</body>
</html>