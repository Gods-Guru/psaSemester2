<?php

require_once "../includes/auth.php";
require_once "../includes/database.php";

$error = "";
$success = "";

/*
|--------------------------------------------------------------------------
| GET GALLERY ITEM
|--------------------------------------------------------------------------
*/

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid gallery item.");
}

$gallery_id = (int) $_GET["id"];

$stmt = $conn->prepare(
    "SELECT * FROM gallery WHERE id = ?"
);

$stmt->bind_param("i", $gallery_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $stmt->close();
    die("Gallery item not found.");
}

$gallery = $result->fetch_assoc();

$stmt->close();


/*
|--------------------------------------------------------------------------
| UPDATE GALLERY ITEM
|--------------------------------------------------------------------------
*/

if (isset($_POST["update_gallery"])) {

    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if ($title === "") {

        $error = "Please enter a gallery title.";

    } else {

        $stmt = $conn->prepare(
            "UPDATE gallery
             SET title = ?, description = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "ssi",
            $title,
            $description,
            $gallery_id
        );

        if ($stmt->execute()) {

            $success = "Gallery item updated successfully.";

            // Update displayed values immediately
            $gallery["title"] = $title;
            $gallery["description"] = $description;

        } else {

            $error = "Failed to update gallery item.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Gallery Item | My Next Level</title>

    <link
        rel="stylesheet"
        href="../assets/css/index.css"
    >
    <link
        rel="stylesheet"
        href="../assets/css/admin.css"
    >

</head>

<body class="admin-gallery">

    <div class="admin-layout">
        <?php require_once "admin-navigation.php"; ?>

        <main class="admin-main">

        <section aria-labelledby="edit-gallery-heading">

            <h1 id="edit-gallery-heading">
                Edit Gallery Item
            </h1>


            <?php if (!empty($success)): ?>

                <div
                    role="status"
                    aria-live="polite"
                >
                    <?php echo htmlspecialchars($success); ?>
                </div>

            <?php endif; ?>


            <?php if (!empty($error)): ?>

                <div
                    role="alert"
                    aria-live="assertive"
                >
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php endif; ?>


            <div>

                <img
                    src="../<?php echo htmlspecialchars($gallery["image"]); ?>"
                    alt="<?php echo htmlspecialchars($gallery["title"]); ?>"
                    width="300"
                >

            </div>


            <form method="POST">

                <div>

                    <label for="gallery-title">
                        Title
                    </label>

                    <input
                        id="gallery-title"
                        type="text"
                        name="title"
                        value="<?php echo htmlspecialchars($gallery["title"]); ?>"
                        required
                    >

                </div>


                <div>

                    <label for="gallery-description">
                        Description
                    </label>

                    <textarea
                        id="gallery-description"
                        name="description"
                        rows="6"
                    ><?php echo htmlspecialchars($gallery["description"] ?? ""); ?></textarea>

                </div>


                <button
                    type="submit"
                    name="update_gallery"
                >
                    Save Changes
                </button>

                <a href="gallery.php">
                    Cancel
                </a>

            </form>

        </section>

        </main>
    </div>

    <script src="../assets/js/components.js"></script>

</body>

</html>