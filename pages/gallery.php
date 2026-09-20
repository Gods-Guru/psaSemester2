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
</head>

<body>

    <site-header></site-header>

    <main>

        <section aria-labelledby="gallery-heading">

            <h1 id="gallery-heading">Gallery</h1>

            <p>
                Explore moments from our programmes and community activities.
            </p>

            <?php if ($result->num_rows > 0): ?>

                <div class="gallery-grid">

                    <?php while ($item = $result->fetch_assoc()): ?>

                        <article class="gallery-item">

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