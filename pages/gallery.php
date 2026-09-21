<?php

require_once "../includes/database.php";

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gallery | My Next Level</title>
    <meta
        name="description"
        content="View moments and activities from My Next Level."
    >

    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/gallery.css">
    <link rel="stylesheet" href="../assets/css/components.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
</head>

<body class="public-site">

    <site-header></site-header>

    <main class="public-page gallery-page">

        <section class="public-hero gallery-hero" aria-labelledby="gallery-heading">

            <p>Gallery</p>
            <h1 id="gallery-heading">Gallery</h1>

            <p>
                Explore moments from our programmes and community activities.
            </p>

        </section>

        <section class="public-section gallery-content" aria-label="Gallery entries">

            <?php if ($result->num_rows > 0): ?>

                <div class="gallery-grid">

                    <?php while ($item = $result->fetch_assoc()): ?>

                        <article class="public-card gallery-item">

                            <img
                                src="../<?php echo htmlspecialchars($item["image"]); ?>"
                                alt="<?php echo htmlspecialchars($item["title"]); ?>"
                            >

                            <div class="gallery-item-content">

                                <h2>
                                    <?php echo htmlspecialchars($item["title"]); ?>
                                </h2>

                                <?php if (!empty($item["description"])): ?>

                                    <p>
                                        <?php echo nl2br(htmlspecialchars($item["description"])); ?>
                                    </p>

                                <?php endif; ?>

                            </div>

                        </article>

                    <?php endwhile; ?>

                </div>

            <?php else: ?>

                <p>No gallery items have been added yet.</p>

            <?php endif; ?>

        </section>

    </main>

    <site-footer></site-footer>

    <script src="../assets/js/components.js"></script>

</body>
</html>