<?php

require_once "../includes/auth.php";
require_once "../includes/database.php";

$message = "";
$error = "";

/*
|--------------------------------------------------------------------------
| DELETE GALLERY ITEM
|--------------------------------------------------------------------------
*/

if (isset($_POST["delete_gallery"])) {

    $gallery_id = (int) $_POST["gallery_id"];

    // Get image path before deleting database record
    $stmt = $conn->prepare(
        "SELECT image FROM gallery WHERE id = ?"
    );

    $stmt->bind_param("i", $gallery_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $gallery_item = $result->fetch_assoc();

        $image_path = "../" . $gallery_item["image"];

        $stmt->close();

        // Delete database record
        $stmt = $conn->prepare(
            "DELETE FROM gallery WHERE id = ?"
        );

        $stmt->bind_param("i", $gallery_id);

        if ($stmt->execute()) {

            // Delete physical image if it exists
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            $message = "Gallery item deleted successfully.";

        } else {

            $error = "Failed to delete gallery item.";
        }

        $stmt->close();

    } else {

        $stmt->close();

        $error = "Gallery item not found.";
    }
}


/*
|--------------------------------------------------------------------------
| ADD GALLERY ITEM
|--------------------------------------------------------------------------
*/

if (isset($_POST["add_gallery"])) {

    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if ($title === "") {

        $error = "Please enter a gallery title.";

    } elseif (
        !isset($_FILES["image"]) ||
        $_FILES["image"]["error"] !== UPLOAD_ERR_OK
    ) {

        $error = "Please select a valid image.";

    } else {

        $image = $_FILES["image"];

        // Maximum file size: 5MB
        $max_size = 5 * 1024 * 1024;

        if ($image["size"] > $max_size) {

            $error = "Image must not exceed 5MB.";

        } else {

            // Verify that the file is actually an image
            $image_info = getimagesize($image["tmp_name"]);

            if ($image_info === false) {

                $error = "The uploaded file is not a valid image.";

            } else {

                $allowed_types = [
                    "image/jpeg" => "jpg",
                    "image/png" => "png",
                    "image/webp" => "webp"
                ];

                $mime_type = $image_info["mime"];

                if (!isset($allowed_types[$mime_type])) {

                    $error = "Only JPG, PNG, and WebP images are allowed.";

                } else {

                    $extension = $allowed_types[$mime_type];

                    // Generate a random filename
                    $filename = bin2hex(random_bytes(16)) . "." . $extension;

                    $upload_directory = "../assets/uploads/gallery/";

                    if (!is_dir($upload_directory)) {
                        mkdir($upload_directory, 0755, true);
                    }

                    $upload_path = $upload_directory . $filename;

                    // Path stored in database
                    $database_path =
                        "assets/uploads/gallery/" . $filename;

                    if (move_uploaded_file(
                        $image["tmp_name"],
                        $upload_path
                    )) {

                        $stmt = $conn->prepare(
                            "INSERT INTO gallery
                            (title, image, description)
                            VALUES (?, ?, ?)"
                        );

                        $stmt->bind_param(
                            "sss",
                            $title,
                            $database_path,
                            $description
                        );

                        if ($stmt->execute()) {

                            $message =
                                "Gallery item added successfully.";

                        } else {

                            // Remove uploaded image if DB insertion fails
                            if (file_exists($upload_path)) {
                                unlink($upload_path);
                            }

                            $error =
                                "Gallery item could not be saved.";
                        }

                        $stmt->close();

                    } else {

                        $error = "Failed to upload the image.";
                    }
                }
            }
        }
    }
}


/*
|--------------------------------------------------------------------------
| FETCH GALLERY ITEMS
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT *
    FROM gallery
    ORDER BY created_at DESC
";

$result = $conn->query($sql);

if (!$result) {
    die("Gallery query failed: " . $conn->error);
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

    <title>Gallery Management | My Next Level</title>

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

        <header class="admin-page-header admin-header">
            <div>
                <p>Gallery</p>
                <h1 id="gallery-heading">Gallery Management</h1>
            </div>
        </header>

        <section class="admin-form-card" aria-labelledby="gallery-heading">

            <p>
                Add and manage images for the public gallery.
            </p>


            <?php if (!empty($message)): ?>

                <div
                    class="admin-success-message"
                    role="status"
                    aria-live="polite"
                >
                    <?php echo htmlspecialchars($message); ?>
                </div>

            <?php endif; ?>


            <?php if (!empty($error)): ?>

                <div
                    class="admin-error-message"
                    role="alert"
                    aria-live="assertive"
                >
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php endif; ?>


            <!-- ADD GALLERY ITEM -->

            <section aria-labelledby="add-gallery-heading">

                <h2 id="add-gallery-heading">
                    Add Gallery Item
                </h2>

                <form
                    method="POST"
                    enctype="multipart/form-data"
                    class="admin-form-grid"
                >

                    <div>

                        <label for="gallery-title">
                            Title
                        </label>

                        <input
                            id="gallery-title"
                            type="text"
                            name="title"
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
                            rows="5"
                        ></textarea>

                    </div>


                    <div>

                        <label for="gallery-image">
                            Image
                        </label>

                        <input
                            id="gallery-image"
                            type="file"
                            name="image"
                            accept=".jpg,.jpeg,.png,.webp"
                            required
                        >

                        <small>
                            JPG, PNG, or WebP. Maximum size: 5MB.
                        </small>

                    </div>


                    <div class="admin-actions">
                        <button
                            type="submit"
                            name="add_gallery"
                        >
                            Add Gallery Item
                        </button>
                    </div>

                </form>

            </section>


            <!-- EXISTING GALLERY ITEMS -->

            <section aria-labelledby="gallery-items-heading">

                <h2 id="gallery-items-heading">
                    Existing Gallery Items
                </h2>


                <?php if ($result->num_rows > 0): ?>

                    <div class="gallery-grid">

                        <?php while (
                            $item = $result->fetch_assoc()
                        ): ?>

                            <article class="gallery-item">

                                <img
                                    src="../<?php echo htmlspecialchars(
                                        $item["image"]
                                    ); ?>"
                                    alt="<?php echo htmlspecialchars(
                                        $item["title"]
                                    ); ?>"
                                    width="300"
                                >


                                <h3>
                                    <?php echo htmlspecialchars(
                                        $item["title"]
                                    ); ?>
                                </h3>


                                <?php if (
                                    !empty($item["description"])
                                ): ?>

                                    <p>
                                        <?php echo nl2br(
                                            htmlspecialchars(
                                                $item["description"]
                                            )
                                        ); ?>
                                    </p>

                                <?php endif; ?>


                                <a href="edit-gallery.php?id=<?php echo $item["id"]; ?>">
    Edit
</a>

                                <form method="POST">

                                    <input
                                        type="hidden"
                                        name="gallery_id"
                                        value="<?php echo $item["id"]; ?>"
                                    >

                                    <button
                                        type="submit"
                                        name="delete_gallery"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </article>

                        <?php endwhile; ?>

                    </div>

                <?php else: ?>

                    <p>
                        No gallery items have been added yet.
                    </p>

                <?php endif; ?>

            </section>

        </section>

        </main>
    </div>


    <script src="../assets/js/components.js"></script>

</body>

</html>