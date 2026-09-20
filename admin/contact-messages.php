<?php

require_once "../includes/auth.php";
require_once "../includes/database.php";

$message = "";
$error = "";

// DELETE CONTACT MESSAGE
if (isset($_POST["delete_message"])) {

    $contact_id = (int) $_POST["contact_id"];

    $stmt = $conn->prepare(
        "DELETE FROM contacts WHERE id = ?"
    );

    $stmt->bind_param(
        "i",
        $contact_id
    );

    if ($stmt->execute()) {
        $message = "Contact message deleted successfully.";
    } else {
        $error = "Failed to delete contact message.";
    }

    $stmt->close();
}

// GET CONTACT MESSAGES
$sql = "
    SELECT *
    FROM contacts
    ORDER BY created_at DESC
";

$result = $conn->query($sql);

if (!$result) {
    $error = "Failed to load contact messages.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact Messages | My Next Level</title>

    <link rel="stylesheet" href="../assets/css/index.css">

</head>

<body>

    <main>

        <h1>Contact Messages</h1>

        <p>Review messages submitted through the website contact form.</p>


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

            <section aria-labelledby="contact-messages-heading">

                <h2 id="contact-messages-heading">
                    Messages
                </h2>


                <?php while ($contact = $result->fetch_assoc()): ?>

                    <article>

                        <h3>
                            <?php echo htmlspecialchars($contact["subject"]); ?>
                        </h3>


                        <p>
                            <strong>Name:</strong>
                            <?php echo htmlspecialchars($contact["name"]); ?>
                        </p>


                        <p>
                            <strong>Email:</strong>
                            <?php echo htmlspecialchars($contact["email"]); ?>
                        </p>


                        <p>
                            <strong>Message:</strong>
                            <?php echo nl2br(htmlspecialchars($contact["message"])); ?>
                        </p>


                        <p>
                            <strong>Submitted:</strong>
                            <?php echo htmlspecialchars($contact["created_at"]); ?>
                        </p>


                        <!-- DELETE -->

                        <form method="POST">

                            <input
                                type="hidden"
                                name="contact_id"
                                value="<?php echo $contact["id"]; ?>"
                            >

                            <button
                                type="submit"
                                name="delete_message"
                            >
                                Delete
                            </button>

                        </form>


                        <hr>

                    </article>

                <?php endwhile; ?>

            </section>

        <?php else: ?>

            <p>No contact messages found.</p>

        <?php endif; ?>

    </main>

</body>
</html>