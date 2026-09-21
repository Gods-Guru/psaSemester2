<?php
require_once "includes/database.php";

$homepage_programs = [];
$programs_query = $conn->query(
    "SELECT id, title, description, image, location, program_date, status
     FROM programs
     ORDER BY
        CASE status
            WHEN 'ongoing' THEN 1
            WHEN 'upcoming' THEN 2
            WHEN 'completed' THEN 3
            ELSE 4
        END,
        program_date ASC,
        created_at DESC
     LIMIT 3"
);

if ($programs_query) {
    while ($program = $programs_query->fetch_assoc()) {
        $homepage_programs[] = $program;
    }
}

$homepage_gallery = [];
$gallery_query = $conn->query(
    "SELECT title, image, description, created_at
     FROM gallery
     ORDER BY created_at DESC
     LIMIT 3"
);

if ($gallery_query) {
    while ($gallery_item = $gallery_query->fetch_assoc()) {
        $homepage_gallery[] = $gallery_item;
    }
}

$homepage_metrics = [
    "programmes" => 0,
    "volunteer_applications" => 0,
    "community_reports" => 0,
    "gallery_stories" => 0
];

$metric_queries = [
    "programmes" => "SELECT COUNT(*) AS total FROM programs",
    "volunteer_applications" => "SELECT COUNT(*) AS total FROM volunteers",
    "community_reports" => "SELECT COUNT(*) AS total FROM community_reports",
    "gallery_stories" => "SELECT COUNT(*) AS total FROM gallery"
];

foreach ($metric_queries as $metric => $query) {
    $metric_result = $conn->query($query);

    if ($metric_result) {
        $homepage_metrics[$metric] = (int) $metric_result->fetch_assoc()["total"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Next Level | Charity Organisation</title>
    <meta name="description" content="My Next Level charity organisation website landing page." />
    <link rel="stylesheet" href="assets/css/index.css" />
    <link rel="stylesheet" href="assets/css/home.css" />
    <link rel="stylesheet" href="assets/css/components.css" />
    <link rel="stylesheet" href="assets/css/responsive.css" />
</head>
<body class="public-site">
    <site-header></site-header>

    <main>
        <section aria-labelledby="home-hero-heading">
            <div>
                <p style="color: #fff;">My Next Level</p>
                <h1 id="home-hero-heading">Helping communities move forward with support, care and opportunity.</h1>
                <p>My Next Level is a charity organisation focused on creating a stronger digital presence to connect donors, sponsors, volunteers and communities in need.</p>
                <div>
                    <a href="pages/donate.php">Donate</a>
                    <a href="pages/volunteer.php">Volunteer</a>
                </div>
            </div>
            <div>
                <img src="assets/images/image4.jpg" alt="Community support activity from My Next Level." />
            </div>
        </section>

        <section aria-labelledby="about-intro-heading">
            <div>
                <p>About us</p>
                <h2 id="about-intro-heading">A charity organisation built around community support.</h2>
            </div>
            <div>
                <article>
                    <h3>Community care</h3>
                    <p>Supporting communities through care, opportunity and practical action.</p>
                </article>
                <article>
                    <h3>Connection</h3>
                    <p>Connecting donors, sponsors, volunteers and communities in need.</p>
                </article>
                <article>
                    <h3>Opportunity</h3>
                    <p>Creating pathways for people to take part in meaningful community support.</p>
                </article>
            </div>
            <p><a href="pages/about.php">Learn more about My Next Level</a></p>
        </section>

        <section aria-labelledby="programmes-preview-heading">
            <div>
                <p>Programmes</p>
                <h2 id="programmes-preview-heading">Supporting communities through practical action.</h2>
                <p>Explore current programme areas and upcoming initiatives designed to support community care and opportunity.</p>
            </div>

            <?php if ($homepage_programs): ?>
                <div class="programs-list">
                    <?php foreach ($homepage_programs as $program): ?>
                        <article class="program-card">
                            <?php if (!empty($program["image"])): ?>
                                <img
                                    src="<?php echo htmlspecialchars($program["image"]); ?>"
                                    alt="<?php echo htmlspecialchars($program["title"]); ?>"
                                />
                            <?php endif; ?>

                            <h3><?php echo htmlspecialchars($program["title"]); ?></h3>
                            <p><?php echo htmlspecialchars($program["description"]); ?></p>

                            <?php if (!empty($program["status"])): ?>
                                <p><strong>Status:</strong> <?php echo htmlspecialchars($program["status"]); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($program["program_date"])): ?>
                                <p><strong>Date:</strong> <?php echo htmlspecialchars($program["program_date"]); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($program["location"])): ?>
                                <p><strong>Location:</strong> <?php echo htmlspecialchars($program["location"]); ?></p>
                            <?php endif; ?>

                            <a href="pages/programs.php">View programmes</a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No programmes are available at the moment.</p>
            <?php endif; ?>
        </section>

        <section aria-labelledby="impact-heading">
            <div>
                <p>Impact</p>
                <h2 id="impact-heading">Our work is rooted in community care.</h2>
            </div>
            <div>
                <article>
                    <h3><?php echo $homepage_metrics["programmes"]; ?></h3>
                    <p>Programmes</p>
                </article>
                <article>
                    <h3><?php echo $homepage_metrics["volunteer_applications"]; ?></h3>
                    <p>Volunteer applications</p>
                </article>
                <article>
                    <h3><?php echo $homepage_metrics["community_reports"]; ?></h3>
                    <p>Community reports</p>
                </article>
                <article>
                    <h3><?php echo $homepage_metrics["gallery_stories"]; ?></h3>
                    <p>Gallery stories</p>
                </article>
            </div>
        </section>

        <section aria-labelledby="gallery-preview-heading">
            <div>
                <p>Gallery</p>
                <h2 id="gallery-preview-heading">Moments of support and connection.</h2>
                <p>Recent stories from community outreach, support work and engagement activities.</p>
            </div>
            <?php if ($homepage_gallery): ?>
                <div class="gallery-grid">
                    <?php foreach ($homepage_gallery as $gallery_item): ?>
                        <figure>
                            <img
                                src="<?php echo htmlspecialchars($gallery_item["image"]); ?>"
                                alt="<?php echo htmlspecialchars($gallery_item["title"]); ?>"
                            />
                            <figcaption><?php echo htmlspecialchars($gallery_item["title"]); ?></figcaption>
                        </figure>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No gallery stories are available at the moment.</p>
            <?php endif; ?>
            <p><a href="pages/gallery.php">View gallery</a></p>
        </section>

        <section aria-labelledby="get-involved-heading">
            <div>
                <p>Get involved</p>
                <h2 id="get-involved-heading">There are many ways to take part.</h2>
            </div>
            <div>
                <article>
                    <h3>Donate</h3>
                    <p>Support the organisation through donations and financial contributions.</p>
                    <a href="pages/donate.php">Donate</a>
                </article>
                <article>
                    <h3>Volunteer</h3>
                    <p>Offer time, skills and local support to community initiatives.</p>
                    <a href="pages/volunteer.php">Volunteer</a>
                </article>
                <article>
                    <h3>Sponsor</h3>
                    <p>Partner with the organisation to support specific needs and initiatives.</p>
                    <a href="pages/sponsor.php">Sponsor</a>
                </article>
                <article>
                    <h3>Tell us about a community</h3>
                    <p>Share information about underserved communities that may need assistance.</p>
                    <a href="pages/community-report.php">Report a community</a>
                </article>
            </div>
        </section>

        <section aria-labelledby="final-cta-heading">
            <h2 id="final-cta-heading">Your support can help communities access care, opportunity and stability.</h2>
            <div>
                <a href="pages/donate.php">Donate</a>
                <a href="pages/volunteer.php">Volunteer</a>
            </div>
        </section>
    </main>

    <site-footer></site-footer>
    <script src="assets/js/components.js"></script>
</body>
</html>
