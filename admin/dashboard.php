<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";

$volunteers = $conn->query("SELECT COUNT(*) AS total FROM volunteers")->fetch_assoc()["total"];

$donations = $conn->query("SELECT COALESCE(SUM(amount), 0) AS total FROM donations")->fetch_assoc()["total"];

$programs = $conn->query("SELECT COUNT(*) AS total FROM programs")->fetch_assoc()["total"];

$reports = $conn->query("SELECT COUNT(*) AS total FROM community_reports")->fetch_assoc()["total"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | My Next Level</title>
    <meta name="description" content="Administrative dashboard placeholder for My Next Level." />
    <link rel="stylesheet" href="../assets/css/index.css" />
</head>
<body>
    <aside>
        <h1>My Next Level</h1>
        <nav aria-label="Admin navigation">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="programs.php">Content</a></li>
                <li><a href="programs.php">Programmes</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="volunteers.php">Volunteers</a></li>
                <li><a href="donations.php">Donations</a></li>
                <li><a href="sponsors.php">Sponsors</a></li>
                <li><a href="community-reports.php">Community Reports</a></li>
                <li><a href="dashboard.php">Analytics</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <main>
        <header>
            <h2>Dashboard overview</h2>
        </header>

        <section aria-label="Summary statistics">
            <article>
                <h3>Total volunteers</h3>
                <p>
                    <?php echo $volunteers; ?>
                </p>
            </article>
            <article>
                <h3>Total donations</h3>
                <p>$<?php echo number_format($donations, 2); ?></p>
            </article>
            <article>
                <h3>Total programmes</h3>
                <p><?php echo $programs; ?></p>
            </article>
            <article>
                <h3>Community reports</h3>
                <p><?php echo $reports; ?></p>
            </article>
            <article>
                <h3>Website visitors</h3>
                <p>[Number placeholder]</p>
            </article>
        </section>

        <section aria-labelledby="programme-attention-heading">
            <h2 id="programme-attention-heading">Programme attention</h2>
            <p>[Placeholder section for highlighting the programmes receiving the most attention.]</p>
        </section>

        <section aria-labelledby="recent-activity-heading">
            <h2 id="recent-activity-heading">Recent activity</h2>
            <table>
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Details</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>[Activity placeholder]</td>
                        <td>[Details placeholder]</td>
                        <td>[Date placeholder]</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section aria-labelledby="donation-overview-heading">
            <h2 id="donation-overview-heading">Donation overview</h2>
            <p>[Placeholder section for donation statistics and trends.]</p>
        </section>

        <section aria-labelledby="website-statistics-heading">
            <h2 id="website-statistics-heading">Website statistics</h2>
            <div>
                <article>
                    <h3>Visitors</h3>
                    <p>[Placeholder]</p>
                </article>
                <article>
                    <h3>Donations</h3>
                    <p>[Placeholder]</p>
                </article>
                <article>
                    <h3>Volunteers</h3>
                    <p>[Placeholder]</p>
                </article>
            </div>
        </section>
    </main>
</body>
</html>
