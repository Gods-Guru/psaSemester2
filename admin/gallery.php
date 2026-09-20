<?php

require_once "../includes/auth.php";
require_once "../includes/database.php";

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if ($title === "") {

        $error = "Please enter a gallery title.";

    } elseif (!isset($_FILES["image"]) || $_FILES["image"]["error"] !== UPLOAD_ERR_OK) {

        $error = "Please select a valid image.";

    } else {

        $image = $_FILES["image"];

        // Maximum file size: 5MB
        $max_size = 5 * 1024 * 1024;

        if ($image["size"] > $max_size) {

            $error = "Image must not exceed 5MB.";

        } else {

            // Check that the uploaded file is actually an image
            $image_info = getimagesize($image["tmp_name"]);

            if ($image_info === false) {

                $error = "The uploaded file is not a valid image.";

            } else {

                // Allowed image types
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

                    // Generate a unique filename
                    $filename = bin2hex(random_bytes(16)) . "." . $extension;

                    // Gallery upload directory
                    $upload_directory = "../assets/uploads/gallery/";

                    // Create directory if it doesn't exist
                    if (!is_dir($upload_directory)) {
                        mkdir($upload_directory, 0755, true);
                    }

                    $upload_path = $upload_directory . $filename;

                    // Path stored in the database
                    $database_path = "assets/uploads/gallery/" . $filename;

                    if (move_uploaded_file($image["tmp_name"], $upload_path)) {

                        $stmt = $conn->prepare(
                            "INSERT INTO gallery (title, image, description)
                             VALUES (?, ?, ?)"
                        );

                        $stmt->bind_param(
                            "sss",
                            $title,
                            $database_path,
                            $description
                        );

                        if ($stmt->execute()) {

                            $message = "Gallery item added successfully.";

                        } else {

                            // Remove uploaded file if database insertion fails
                            if (file_exists($upload_path)) {
                                unlink($upload_path);
                            }

                            $error = "Gallery item could not be saved.";
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gallery Management | My Next Level</title>

    <link rel="stylesheet" href="../assets/css/index.css">
</head>

<body>

    <site-header></site-header>

    <main>

        <section aria-labelledby="gallery-heading">

            <h1 id="gallery-heading">Gallery Management</h1>

            <p>Manage image gallery content.</p>

            <?php if (!empty($message)): ?>
                <div role="status" aria-live="polite">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div role="alert" aria-live="assertive">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <h2>Add Gallery Item</h2>

            <form method="POST" enctype="multipart/form-data">

                <div>
                    <label for="gallery-title">Title</label>

                    <input
                        id="gallery-title"
                        type="text"
                        name="title"
                        required
                    >
                </div>

                <div>
                    <label for="gallery-description">Description</label>

                    <textarea
                        id="gallery-description"
                        name="description"
                        rows="5"
                    ></textarea>
                </div>

                <div>
                    <label for="gallery-image">Image</label>

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

                <button type="submit">
                    Add Gallery Item
                </button>

            </form>

        </section>

    </main>

    <site-footer></site-footer>

    <script src="../assets/js/components.js"></script>

</body>
</html>