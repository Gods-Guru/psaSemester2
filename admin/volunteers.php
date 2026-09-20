<?php

require_once "../includes/auth.php";
require_once "../includes/database.php";

$message = "";
$error = "";

// UPDATE VOLUNTEER STATUS
if (isset($_POST["update_status"])) {

    $volunteer_id = (int) $_POST["volunteer_id"];
    $status = trim($_POST["status"]);

    $stmt = $conn->prepare(
        "UPDATE volunteers SET status = ? WHERE id = ?"
    );

    $stmt->bind_param(
        "si",
        $status,
        $volunteer_id
    );

    if ($stmt->execute()) {
        $message = "Volunteer status updated successfully.";
    } else {
        $error = "Failed to update volunteer status.";
    }

    $stmt->close();
}

// DELETE VOLUNTEER
if (isset($_POST["delete_volunteer"])) {

    $volunteer_id = (int) $_POST["volunteer_id"];

    $stmt = $conn->prepare(
        "DELETE FROM volunteers WHERE id = ?"
    );

    $stmt->bind_param(
        "i",
        $volunteer_id
    );

    if ($stmt->execute()) {
        $message = "Volunteer record deleted successfully.";
    } else {
        $error = "Failed to delete volunteer record.";
    }

    $stmt->close();
}

// GET VOLUNTEERS
$sql = "
    SELECT 
        volunteers.*,
        programs.title AS program_title
    FROM volunteers
    LEFT JOIN programs
        ON volunteers.program_id = programs.id
    ORDER BY volunteers.created_at DESC
";

$result = $conn->query($sql);

if (!$result) {
    $error = "Failed to load volunteer records.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Volunteers Management | My Next Level</title>

    <link rel="stylesheet" href="../assets/css/index.css">
</head>

<body>

    <main>

        <h1>Volunteer Management</h1>

        <p>Review and manage volunteer applications.</p>

        <?php if ($message): ?>

            <div role="status" aria-live="polite">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php endif; ?>


        <?php if ($error): ?>

            <div role="alert" aria-live="assertive">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <?php if ($result && $result->num_rows > 0): ?>

            <section aria-labelledby="volunteer-records-heading">

                <h2 id="volunteer-records-heading">
                    Volunteer Applications
                </h2>

                <?php while ($volunteer = $result->fetch_assoc()): ?>

                    <article>

                        <h3>
                            <?php echo htmlspecialchars($volunteer["full_name"]); ?>
                        </h3>

                        <p>
                            <strong>Email:</strong>
                            <?php echo htmlspecialchars($volunteer["email"]); ?>
                        </p>

                        <p>
                            <strong>Phone:</strong>
                            <?php echo htmlspecialchars($volunteer["phone"] ?? "Not provided"); ?>
                        </p>

                        <p>
                            <strong>Programme:</strong>
                            <?php
                            echo htmlspecialchars(
                                $volunteer["program_title"] ?? "No programme selected"
                            );
                            ?>
                        </p>

                        <p>
                            <strong>Skills:</strong>
                            <?php echo htmlspecialchars($volunteer["skills"] ?? "Not provided"); ?>
                        </p>

                        <p>
                            <strong>Availability:</strong>
                            <?php echo htmlspecialchars($volunteer["availability"] ?? "Not provided"); ?>
                        </p>

                        <p>
                            <strong>Message:</strong>
                            <?php echo nl2br(htmlspecialchars($volunteer["message"])); ?>
                        </p>

                        <p>
                            <strong>Submitted:</strong>
                            <?php echo htmlspecialchars($volunteer["created_at"]); ?>
                        </p>


                        <!-- STATUS -->

                        <form method="POST">

                            <input
                                type="hidden"
                                name="volunteer_id"
                                value="<?php echo $volunteer["id"]; ?>"
                            >

                            <label for="status-<?php echo $volunteer["id"]; ?>">
                                Status
                            </label>

                            <select
                                id="status-<?php echo $volunteer["id"]; ?>"
                                name="status"
                            >

                                <option
                                    value="pending"
                                    <?php echo $volunteer["status"] === "pending" ? "selected" : ""; ?>
                                >
                                    Pending
                                </option>

                                <option
                                    value="approved"
                                    <?php echo $volunteer["status"] === "approved" ? "selected" : ""; ?>
                                >
                                    Approved
                                </option>

                                <option
                                    value="rejected"
                                    <?php echo $volunteer["status"] === "rejected" ? "selected" : ""; ?>
                                >
                                    Rejected
                                </option>

                            </select>

                            <button type="submit" name="update_status">
                                Update Status
                            </button>

                        </form>


                        <!-- DELETE -->

                        <form method="POST">

                            <input
                                type="hidden"
                                name="volunteer_id"
                                value="<?php echo $volunteer["id"]; ?>"
                            >

                            <button
                                type="submit"
                                name="delete_volunteer"
                            >
                                Delete
                            </button>

                        </form>

                        <hr>

                    </article>

                <?php endwhile; ?>

            </section>

        <?php else: ?>

            <p>No volunteer applications found.</p>

        <?php endif; ?>

    </main>

</body>
</html>