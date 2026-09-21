<?php

require_once "../includes/auth.php";
require_once "../includes/database.php";

$message = "";
$error = "";

// UPDATE SPONSOR STATUS
if (isset($_POST["update_status"])) {

    $sponsor_id = (int) $_POST["sponsor_id"];
    $status = trim($_POST["status"]);

    $stmt = $conn->prepare(
        "UPDATE sponsors SET status = ? WHERE id = ?"
    );

    $stmt->bind_param(
        "si",
        $status,
        $sponsor_id
    );

    if ($stmt->execute()) {
        $message = "Sponsor status updated successfully.";
    } else {
        $error = "Failed to update sponsor status.";
    }

    $stmt->close();
}

// DELETE SPONSOR
if (isset($_POST["delete_sponsor"])) {

    $sponsor_id = (int) $_POST["sponsor_id"];

    $stmt = $conn->prepare(
        "DELETE FROM sponsors WHERE id = ?"
    );

    $stmt->bind_param(
        "i",
        $sponsor_id
    );

    if ($stmt->execute()) {
        $message = "Sponsor record deleted successfully.";
    } else {
        $error = "Failed to delete sponsor record.";
    }

    $stmt->close();
}

// GET SPONSORS
$sql = "SELECT * FROM sponsors ORDER BY created_at DESC";

$result = $conn->query($sql);

if (!$result) {
    $error = "Failed to load sponsor records.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sponsors | My Next Level</title>

    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

    <div class="admin-layout">
        <?php require_once "admin-navigation.php"; ?>

        <main class="admin-main">

        <h1>Manage Sponsors</h1>

        <p>Review and manage sponsorship enquiries.</p>

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

            <section aria-labelledby="sponsor-records-heading">

                <h2 id="sponsor-records-heading">
                    Sponsor Enquiries
                </h2>

                <?php while ($sponsor = $result->fetch_assoc()): ?>

                    <article>

                        <h3>
                            <?php echo htmlspecialchars($sponsor["full_name"]); ?>
                        </h3>

                        <p>
                            <strong>Organisation:</strong>
                            <?php echo htmlspecialchars($sponsor["organisation"] ?? "Not provided"); ?>
                        </p>

                        <p>
                            <strong>Email:</strong>
                            <?php echo htmlspecialchars($sponsor["email"]); ?>
                        </p>

                        <p>
                            <strong>Phone:</strong>
                            <?php echo htmlspecialchars($sponsor["phone"] ?? "Not provided"); ?>
                        </p>

                        <p>
                            <strong>Sponsorship type:</strong>
                            <?php echo htmlspecialchars($sponsor["sponsorship_type"] ?? "Not specified"); ?>
                        </p>

                        <p>
                            <strong>Message:</strong>
                            <?php echo nl2br(htmlspecialchars($sponsor["message"])); ?>
                        </p>

                        <p>
                            <strong>Submitted:</strong>
                            <?php echo htmlspecialchars($sponsor["created_at"]); ?>
                        </p>


                        <!-- STATUS -->

                        <form method="POST">

                            <input
                                type="hidden"
                                name="sponsor_id"
                                value="<?php echo $sponsor["id"]; ?>"
                            >

                            <label for="status-<?php echo $sponsor["id"]; ?>">
                                Status
                            </label>

                            <select
                                id="status-<?php echo $sponsor["id"]; ?>"
                                name="status"
                            >

                                <option
                                    value="pending"
                                    <?php echo $sponsor["status"] === "pending" ? "selected" : ""; ?>
                                >
                                    Pending
                                </option>

                                <option
                                    value="approved"
                                    <?php echo $sponsor["status"] === "approved" ? "selected" : ""; ?>
                                >
                                    Approved
                                </option>

                                <option
                                    value="rejected"
                                    <?php echo $sponsor["status"] === "rejected" ? "selected" : ""; ?>
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
                                name="sponsor_id"
                                value="<?php echo $sponsor["id"]; ?>"
                            >

                            <button
                                type="submit"
                                name="delete_sponsor"
                            >
                                Delete
                            </button>

                        </form>

                        <hr>

                    </article>

                <?php endwhile; ?>

            </section>

        <?php else: ?>

            <p>No sponsor enquiries found.</p>

        <?php endif; ?>

        </main>
    </div>

</body>
</html>