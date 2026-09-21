<?php
require_once "../includes/database.php";

$programs = $conn->query(
    "SELECT id, title, description, image, location, program_date, status
     FROM programs
     ORDER BY program_date ASC, created_at DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programmes | My Next Level</title>
    <meta name="description" content="Programmes and initiatives at My Next Level." />
    <link rel="stylesheet" href="../assets/css/index.css" />
    <link rel="stylesheet" href="../assets/css/programs.css" />
    <link rel="stylesheet" href="../assets/css/components.css" />
    <link rel="stylesheet" href="../assets/css/responsive.css" />
</head>
<body class="public-site">
    <site-header></site-header>

    <main class="public-page programs-page">
        <section class="public-hero programs-hero" aria-labelledby="programmes-page-heading">
            <p>Programmes</p>
            <h1 id="programmes-page-heading">Current programme areas and initiatives.</h1>
            <p>Explore current programme areas and initiatives designed to support community care and opportunity.</p>
        </section>

        <section class="public-section programs-list" aria-label="Programme list">
            <?php if ($programs && $programs->num_rows > 0): ?>
                <?php while ($program = $programs->fetch_assoc()): ?>
                    <article class="public-card program-card">
                        <?php if (!empty($program["image"])): ?>
                            <img
                                src="../<?php echo htmlspecialchars($program["image"]); ?>"
                                alt="<?php echo htmlspecialchars($program["title"]); ?>"
                            />
                        <?php endif; ?>

                        <h2><?php echo htmlspecialchars($program["title"]); ?></h2>
                        <p><?php echo htmlspecialchars($program["description"]); ?></p>

                        <?php if (!empty($program["status"])): ?>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars($program["status"]); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($program["location"])): ?>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($program["location"]); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($program["program_date"])): ?>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($program["program_date"]); ?></p>
                        <?php endif; ?>

                        <p><a href="volunteer.php">Volunteer with this programme</a></p>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No programmes are available at the moment.</p>
            <?php endif; ?>
        </section>
    </main>

    <site-footer></site-footer>
    <script src="../assets/js/components.js"></script>
</body>
</html>
