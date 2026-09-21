<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";

$volunteers = $conn->query(
    "SELECT COUNT(*) AS total FROM volunteers"
)->fetch_assoc()["total"];

$pending_volunteers = $conn->query(
    "SELECT COUNT(*) AS total FROM volunteers WHERE status = 'pending'"
)->fetch_assoc()["total"];

$donations = $conn->query(
    "SELECT COALESCE(SUM(amount), 0) AS total
     FROM donations
     WHERE archived = 0"
)->fetch_assoc()["total"];

$pending_donations = $conn->query(
    "SELECT COUNT(*) AS total
     FROM donations
     WHERE payment_status = 'pending' AND archived = 0"
)->fetch_assoc()["total"];

$programs = $conn->query(
    "SELECT COUNT(*) AS total FROM programs"
)->fetch_assoc()["total"];

$sponsors = $conn->query(
    "SELECT COUNT(*) AS total FROM sponsors"
)->fetch_assoc()["total"];

$pending_sponsors = $conn->query(
    "SELECT COUNT(*) AS total
     FROM sponsors
     WHERE status = 'pending'"
)->fetch_assoc()["total"];

$reports = $conn->query(
    "SELECT COUNT(*) AS total FROM community_reports"
)->fetch_assoc()["total"];

$pending_reports = $conn->query(
    "SELECT COUNT(*) AS total
     FROM community_reports
     WHERE status = 'pending'"
)->fetch_assoc()["total"];

$messages = $conn->query(
    "SELECT COUNT(*) AS total FROM contacts"
)->fetch_assoc()["total"];

$recent_volunteers = $conn->query(
    "SELECT full_name, created_at
     FROM volunteers
     ORDER BY created_at DESC
     LIMIT 5"
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | My Next Level</title>
    <meta name="description" content="Administrative dashboard placeholder for My Next Level." />
    <link rel="stylesheet" href="../assets/css/index.css" />
    <link rel="stylesheet" href="../assets/css/admin.css" />
</head>
<body class="admin-dashboard">
    <div class="admin-layout">
        <?php require_once "admin-navigation.php"; ?>

        <main class="admin-main">
        <header class="admin-page-header admin-header">
            <div>
                <!-- <p>Overview</p> -->
                <h1>Dashboard overview</h1>
            </div>
        </header>

        <section class="admin-stats" aria-label="Summary statistics">
            <article class="admin-stat-card">
                <h3>Total volunteers</h3>
                <p><?php echo $volunteers; ?></p>
                <small><?php echo $pending_volunteers; ?> pending</small>
            </article>

            <article class="admin-stat-card">
                <h3>Total donations</h3>
                <p>₦<?php echo number_format($donations, 2); ?></p>
                <small><?php echo $pending_donations; ?> pending</small>
            </article>

            <article class="admin-stat-card">
                <h3>Total programmes</h3>
                <p><?php echo $programs; ?></p>
            </article>

            <article class="admin-stat-card">
                <h3>Total sponsors</h3>
                <p><?php echo $sponsors; ?></p>
                <small><?php echo $pending_sponsors; ?> pending</small>
            </article>

            <article class="admin-stat-card">
                <h3>Community reports</h3>
                <p><?php echo $reports; ?></p>
                <small><?php echo $pending_reports; ?> pending</small>
            </article>

            <article class="admin-stat-card">
                <h3>Contact messages</h3>
                <p><?php echo $messages; ?></p>
            </article>

        </section>

        <section
            class="admin-section"
            aria-labelledby="programme-attention-heading"
        >

            <h2 id="programme-attention-heading">Programme attention</h2>

            <?php
            $programme_attention = $conn->query(
                "SELECT
                    programs.title,
                    COUNT(volunteers.id) AS volunteer_count
                FROM programs
                LEFT JOIN volunteers
                    ON programs.id = volunteers.program_id
                GROUP BY programs.id, programs.title
                ORDER BY volunteer_count DESC
                LIMIT 5"
            );
            ?>

            <?php if ($programme_attention->num_rows > 0): ?>

                <div class="admin-table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Programme</th>
                                <th>Volunteer Applications</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php while ($programme = $programme_attention->fetch_assoc()): ?>

                                <tr>
                                    <td>
                                        <?php echo htmlspecialchars($programme["title"]); ?>
                                    </td>

                                    <td>
                                        <?php echo $programme["volunteer_count"]; ?>
                                    </td>
                                </tr>

                            <?php endwhile; ?>

                        </tbody>
                    </table>
                </div>

            <?php else: ?>

                <p>No programme activity available yet.</p>

            <?php endif; ?>

        </section>

        <section
            class="admin-section"
            aria-labelledby="recent-activity-heading"
        >

            <h2 id="recent-activity-heading">Recent activity</h2>

            <?php if ($recent_volunteers->num_rows > 0): ?>

                <div class="admin-table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Activity</th>
                                <th>Details</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php while ($volunteer = $recent_volunteers->fetch_assoc()): ?>

                                <tr>
                                    <td>New volunteer application</td>

                                    <td>
                                        <?php echo htmlspecialchars($volunteer["full_name"]); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($volunteer["created_at"]); ?>
                                    </td>
                                </tr>

                            <?php endwhile; ?>

                        </tbody>
                    </table>
                </div>

            <?php else: ?>

                <p>No recent volunteer activity.</p>

            <?php endif; ?>

        </section>

        <section
            class="admin-section"
            aria-labelledby="donation-overview-heading"
        >

            <h2 id="donation-overview-heading">Donation overview</h2>

            <?php
            $paid_donations = $conn->query(
                "SELECT COALESCE(SUM(amount), 0) AS total
                FROM donations
                WHERE payment_status = 'paid'
                AND archived = 0"
            )->fetch_assoc()["total"];

            $pending_donation_amount = $conn->query(
                "SELECT COALESCE(SUM(amount), 0) AS total
                FROM donations
                WHERE payment_status = 'pending'
                AND archived = 0"
            )->fetch_assoc()["total"];

            $failed_donation_amount = $conn->query(
                "SELECT COALESCE(SUM(amount), 0) AS total
                FROM donations
                WHERE payment_status = 'failed'
                AND archived = 0"
            )->fetch_assoc()["total"];
            ?>

            <div class="admin-overview-grid">

                <article class="admin-stat-card">
                    <h3>Paid donations</h3>
                    <p>
                        ₦<?php echo number_format($paid_donations, 2); ?>
                    </p>
                </article>

                <article class="admin-stat-card">
                    <h3>Pending donations</h3>
                    <p>
                        ₦<?php echo number_format($pending_donation_amount, 2); ?>
                    </p>
                </article>

                <article class="admin-stat-card">
                    <h3>Failed donations</h3>
                    <p>
                        ₦<?php echo number_format($failed_donation_amount, 2); ?>
                    </p>
                </article>

            </div>

        </section>

        <section
            class="admin-section"
            aria-labelledby="website-statistics-heading"
        >

            <h2 id="website-statistics-heading">Website statistics</h2>

            <div class="admin-overview-grid">

                <article class="admin-stat-card">
                    <h3>Programmes</h3>
                    <p>
                        <?php echo $programs; ?>
                    </p>
                </article>

                <article class="admin-stat-card">
                    <h3>Volunteer applications</h3>
                    <p>
                        <?php echo $volunteers; ?>
                    </p>
                </article>

                <article class="admin-stat-card">
                    <h3>Contact messages</h3>
                    <p>
                        <?php echo $messages; ?>
                    </p>
                </article>

            </div>

            <p>
                Visitor analytics are not currently being tracked.
            </p>

        </section>
        </main>
    </div>
</body>
</html>
