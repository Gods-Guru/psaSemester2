<?php

require_once "../includes/auth.php";
require_once "../includes/database.php";

$message = "";
$error = "";

// UPDATE PAYMENT STATUS
if (isset($_POST["update_status"])) {

    $donation_id = (int) $_POST["donation_id"];
    $payment_status = trim($_POST["payment_status"]);

    $stmt = $conn->prepare(
        "UPDATE donations SET payment_status = ? WHERE id = ?"
    );

    $stmt->bind_param(
        "si",
        $payment_status,
        $donation_id
    );

    if ($stmt->execute()) {
        $message = "Donation payment status updated successfully.";
    } else {
        $error = "Failed to update donation payment status.";
    }

    $stmt->close();
}

// ARCHIVE DONATION
if (isset($_POST["archive_donation"])) {

    $donation_id = (int) $_POST["donation_id"];

    $stmt = $conn->prepare(
        "UPDATE donations SET archived = 1 WHERE id = ?"
    );

    $stmt->bind_param(
        "i",
        $donation_id
    );

    if ($stmt->execute()) {
        $message = "Donation archived successfully.";
    } else {
        $error = "Failed to archive donation.";
    }

    $stmt->close();
}

// GET DONATIONS
$sql = "
    SELECT *
    FROM donations
    WHERE archived = 0
    ORDER BY created_at DESC
";

$result = $conn->query($sql);

if (!$result) {
    $error = "Failed to load donation records.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Donations | My Next Level</title>

    <link rel="stylesheet" href="../assets/css/index.css">

</head>

<body>

    <main>

        <h1>Manage Donations</h1>

        <p>Review and manage donation records.</p>


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

            <section aria-labelledby="donation-records-heading">

                <h2 id="donation-records-heading">
                    Donation Records
                </h2>


                <?php while ($donation = $result->fetch_assoc()): ?>

                    <article>

                        <h3>
                            <?php echo htmlspecialchars($donation["donor_name"]); ?>
                        </h3>


                        <p>
                            <strong>Email:</strong>
                            <?php
                            echo !empty($donation["email"])
                                ? htmlspecialchars($donation["email"])
                                : "Not provided";
                            ?>
                        </p>


                        <p>
                            <strong>Phone:</strong>
                            <?php
                            echo !empty($donation["phone"])
                                ? htmlspecialchars($donation["phone"])
                                : "Not provided";
                            ?>
                        </p>


                        <p>
                            <strong>Amount:</strong>
                            ₦<?php echo number_format((float) $donation["amount"], 2); ?>
                        </p>


                        <p>
                            <strong>Message:</strong>
                            <?php
                            echo !empty($donation["message"])
                                ? nl2br(htmlspecialchars($donation["message"]))
                                : "No message";
                            ?>
                        </p>


                        <p>
                            <strong>Submitted:</strong>
                            <?php echo htmlspecialchars($donation["created_at"]); ?>
                        </p>


                        <!-- PAYMENT STATUS -->

                        <form method="POST">

                            <input
                                type="hidden"
                                name="donation_id"
                                value="<?php echo $donation["id"]; ?>"
                            >

                            <label for="payment-status-<?php echo $donation["id"]; ?>">
                                Payment status
                            </label>

                            <select
                                id="payment-status-<?php echo $donation["id"]; ?>"
                                name="payment_status"
                            >

                                <option
                                    value="pending"
                                    <?php echo $donation["payment_status"] === "pending" ? "selected" : ""; ?>
                                >
                                    Pending
                                </option>

                                <option
                                    value="paid"
                                    <?php echo $donation["payment_status"] === "paid" ? "selected" : ""; ?>
                                >
                                    Paid
                                </option>

                                <option
                                    value="failed"
                                    <?php echo $donation["payment_status"] === "failed" ? "selected" : ""; ?>
                                >
                                    Failed
                                </option>

                            </select>

                            <button type="submit" name="update_status">
                                Update Status
                            </button>

                        </form>


                        <!-- ARCHIVE -->

                        <form method="POST">

                        <input
                            type="hidden"
                            name="donation_id"
                            value="<?php echo $donation["id"]; ?>"
                        >

                        <button
                            type="submit"
                            name="archive_donation"
                        >
                            Archive
                        </button>

                    </form>


                        <hr>

                    </article>

                <?php endwhile; ?>

            </section>

        <?php else: ?>

            <p>No donations found.</p>

        <?php endif; ?>

    </main>

</body>
</html>