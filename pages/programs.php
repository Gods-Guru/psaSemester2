<?php
require_once '../includes/database.php';

$sql = 'SELECT * FROM programs ORDER BY program_date ASC';
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programmes | My Next Level</title>
    <meta name="description" content="Programmes and initiatives at My Next Level." />
    <link rel="stylesheet" href="../assets/css/index.css" />
</head>
<body>
    <site-header></site-header>

    <main>
        <section aria-labelledby="programmes-page-heading">
            <p>Programmes</p>
            <h1 id="programmes-page-heading">Current programme areas and initiatives.</h1>
            <p>[Programme overview placeholder text for the organisation.]</p>
        </section>

        <section class="programs-list" aria-label="Programme list">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($program = $result->fetch_assoc()): ?>
                    <article class="program-card">
                        <?php if (!empty($program['image'])): ?>
                            <img src="../assets/images/<?php echo htmlspecialchars($program['image']); ?>"
                                 alt="<?php echo htmlspecialchars($program['title']); ?>" />
                        <?php endif; ?>

                        <div class="program-card-content">
                            <h2><?php echo htmlspecialchars($program['title']); ?></h2>
                            <p><?php echo htmlspecialchars($program['description']); ?></p>

                            <?php if (!empty($program['status'])): ?>
                                <p><strong>Status:</strong> <?php echo htmlspecialchars($program['status']); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($program['location'])): ?>
                                <p><strong>Location:</strong> <?php echo htmlspecialchars($program['location']); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($program['program_date'])): ?>
                                <p><strong>Date:</strong> <?php echo htmlspecialchars($program['program_date']); ?></p>
                            <?php endif; ?>

                            <p><a href="volunteer.php">Volunteer with this programme</a></p>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No programs available at the moment.</p>
            <?php endif; ?>
        </section>
    </main>

    <site-footer></site-footer>
    <script src="../assets/js/components.js"></script>
</body>
</html>