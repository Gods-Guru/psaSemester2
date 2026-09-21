<?php

require_once "../includes/auth.php";
require_once "../includes/database.php";

$message = "";
$error = "";

// UPDATE REPORT STATUS
if (isset($_POST["update_status"])) {

    $report_id = (int) $_POST["report_id"];
    $status = trim($_POST["status"]);

    $stmt = $conn->prepare(
        "UPDATE community_reports SET status = ? WHERE id = ?"
    );

    $stmt->bind_param(
        "si",
        $status,
        $report_id
    );

    if ($stmt->execute()) {
        $message = "Community report status updated successfully.";
    } else {
        $error = "Failed to update community report status.";
    }

    $stmt->close();
}

// DELETE REPORT
if (isset($_POST["delete_report"])) {

    $report_id = (int) $_POST["report_id"];

    $stmt = $conn->prepare(
        "DELETE FROM community_reports WHERE id = ?"
    );

    $stmt->bind_param(
        "i",
        $report_id
    );

    if ($stmt->execute()) {
        $message = "Community report deleted successfully.";
    } else {
        $error = "Failed to delete community report.";
    }

    $stmt->close();
}

// GET COMMUNITY REPORTS
$sql = "
    SELECT *
    FROM community_reports
    ORDER BY created_at DESC
";

$result = $conn->query($sql);

if (!$result) {
    $error = "Failed to load community reports.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Community Reports | My Next Level</title>

    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/admin.css">

</head>

<body>

    <div class="admin-layout">
        <?php require_once "admin-navigation.php"; ?>

        <main class="admin-main">

        <h1>Manage Community Reports</h1>

        <p>Review and manage reports submitted by community members.</p>


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

            <section aria-labelledby="report-records-heading">

                <h2 id="report-records-heading">
                    Community Reports
                </h2>


                <?php while ($report = $result->fetch_assoc()): ?>

                    <article>

                        <h3>
                            <?php echo htmlspecialchars($report["community_name"]); ?>
                        </h3>


                        <p>
                            <strong>Location:</strong>
                            <?php echo htmlspecialchars($report["location"]); ?>
                        </p>


                        <p>
                            <strong>Need type:</strong>
                            <?php echo htmlspecialchars($report["need_type"]); ?>
                        </p>


                        <p>
                            <strong>Description:</strong>
                            <?php echo nl2br(htmlspecialchars($report["description"])); ?>
                        </p>


                        <p>
                            <strong>People affected:</strong>
                            <?php
                            echo $report["people_affected"] !== null
                                ? htmlspecialchars($report["people_affected"])
                                : "Not provided";
                            ?>
                        </p>


                        <p>
                            <strong>Additional information:</strong>
                            <?php
                            echo !empty($report["additional_information"])
                                ? nl2br(htmlspecialchars($report["additional_information"]))
                                : "None provided";
                            ?>
                        </p>


                        <h4>Reporter Information</h4>

                        <p>
                            <strong>Name:</strong>
                            <?php echo htmlspecialchars($report["reporter_name"]); ?>
                        </p>


                        <p>
                            <strong>Email:</strong>
                            <?php
                            echo !empty($report["email"])
                                ? htmlspecialchars($report["email"])
                                : "Not provided";
                            ?>
                        </p>


                        <p>
                            <strong>Phone:</strong>
                            <?php
                            echo !empty($report["phone"])
                                ? htmlspecialchars($report["phone"])
                                : "Not provided";
                            ?>
                        </p>


                        <p>
                            <strong>Submitted:</strong>
                            <?php echo htmlspecialchars($report["created_at"]); ?>
                        </p>


                        <!-- STATUS -->

                        <form method="POST">

                            <input
                                type="hidden"
                                name="report_id"
                                value="<?php echo $report["id"]; ?>"
                            >

                            <label for="status-<?php echo $report["id"]; ?>">
                                Status
                            </label>

                            <select
                                id="status-<?php echo $report["id"]; ?>"
                                name="status"
                            >

                                <option
                                    value="pending"
                                    <?php echo $report["status"] === "pending" ? "selected" : ""; ?>
                                >
                                    Pending
                                </option>

                                <option
                                    value="reviewed"
                                    <?php echo $report["status"] === "reviewed" ? "selected" : ""; ?>
                                >
                                    Reviewed
                                </option>

                                <option
                                    value="resolved"
                                    <?php echo $report["status"] === "resolved" ? "selected" : ""; ?>
                                >
                                    Resolved
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
                                name="report_id"
                                value="<?php echo $report["id"]; ?>"
                            >

                            <button
                                type="submit"
                                name="delete_report"
                            >
                                Delete
                            </button>

                        </form>


                        <hr>

                    </article>

                <?php endwhile; ?>

            </section>

        <?php else: ?>

            <p>No community reports found.</p>

        <?php endif; ?>

        </main>
    </div>

</body>
</html>