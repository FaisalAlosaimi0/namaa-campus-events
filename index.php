<?php
$pageTitle = 'Home';
require 'includes/db.php';

$featured = null;
$featuredResult = mysqli_query(
    $conn,
    "SELECT * FROM events
     WHERE featured = 1
     ORDER BY event_date ASC
     LIMIT 1"
);

if ($featuredResult) {
    $featured = mysqli_fetch_assoc($featuredResult);
}

$upcomingResult = mysqli_query(
    $conn,
    "SELECT * FROM events
     WHERE event_date >= CURDATE()
     ORDER BY event_date ASC, event_time ASC
     LIMIT 3"
);

$statsResult = mysqli_query(
    $conn,
    "SELECT
        COUNT(*) AS total_events,
        COUNT(DISTINCT category) AS total_categories,
        SUM(available_seats) AS total_seats
     FROM events"
);

$stats = $statsResult ? mysqli_fetch_assoc($statsResult) : null;

require 'includes/header.php';
?>

<section class="hero">
    <div class="shell hero-grid">
        <div class="hero-copy">
            <p class="eyebrow">Namaa Campus Activities Office</p>
            <h1>One board for campus plans.</h1>
            <p>
                Check upcoming activities, read the details, and complete a
                student registration without searching through separate announcements.
            </p>

            <div class="button-row">
                <a class="button" href="events.php">Browse all events</a>
                <a class="button button-light" href="register.php"> Open registration  </a>
            </div>
        </div>

        <aside class="hero-blocks" aria-label="Featured event">
            <div class="block-back-one"></div>
            <div class="block-back-two"></div>

            <?php if ($featured): ?>
            <article class="block-main">
                <img src="<?php echo htmlspecialchars($featured['image']); ?>"
                         alt="<?php echo htmlspecialchars($featured['title']); ?>">

                    <div class="block-content">
                        <span class="ticket">Featured activity</span>
                        <h2><?php echo htmlspecialchars($featured['title']); ?></h2>
                        <p><?php echo htmlspecialchars($featured['short_description']); ?></p>
                        <a class="button button-teal" href="event.php?id=<?php echo (int) $featured['id']; ?>">
                            View details
                        </a>
                    </div>
                </article>
            <?php else: ?>
                <div class="block-main block-content">
                    <h2>No featured event</h2>
                    <p>A featured activity will appear here after it is added to the database.</p>
                </div>
            <?php endif; ?>
        </aside>
    </div>
</section>

<section class="section section-white">
    <div class="shell">
        <div class="section-heading">
            <div>
                <p class="section-code">01 / NEXT</p>
                <h2>Upcoming timeline</h2>
                <p>The next three events are loaded from MySQL.</p>
            </div>

            <a class="button button-light" href="events.php">Open the full board</a>
        </div>

         <?php if ($upcomingResult && mysqli_num_rows($upcomingResult) > 0): ?>
        <div class="timeline">
            <?php while ($event = mysqli_fetch_assoc($upcomingResult)): ?>
            <article class="timeline-item">
                <div class="timeline-date">
                    <strong><?php echo date('d', strtotime($event['event_date'])); ?></strong>
                            <span><?php echo date('M', strtotime($event['event_date'])); ?></span>      
                </div>

                <div class="timeline-card">
                    <img src="<?php echo htmlspecialchars($event['image']); ?>"
                         alt="<?php echo htmlspecialchars($event['title']); ?>">

                    <div class="timeline-copy">
                        <span class="ticket"><?php echo htmlspecialchars($event['category']); ?></span>
                                <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                                <p><?php echo htmlspecialchars($event['short_description']); ?></p>
                                <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                                <a class="button button-light" href="event.php?id=<?php echo (int) $event['id']; ?>">
                            Event information
                        </a>
                    </div>
                </div>
            </article>
         <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h2>No upcoming events</h2>
                <p>The database does not contain any future event dates.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="section section-mint">
    <div class="shell">
        <div class="section-heading">
            <div>
                <p class="section-code">02 / AREAS</p>
                <h2>What the office publishes</h2>
            </div>
        </div>

        <div class="activity-grid">
            <article class="activity-card">
                <h3>Learning</h3>
                <p>Academic practice, research support, technology sessions, and career preparation.</p>
            </article>

            <article class="activity-card">
                <h3>Culture</h3>
                <p>Arabic design, Saudi heritage, reading, communication, and student media.</p>
            </article>

            <article class="activity-card">
                <h3>Community</h3>
                <p>Student dialogue, wellbeing awareness, safety planning, and shared campus activities.</p>
            </article>

            <article class="activity-card">
                <h3>Environment</h3>
                <p>Field activities, renewable energy models, and practical sustainability discussions.</p>
            </article>
        </div>
    </div>
</section>

<section class="section">
    <div class="shell">
        <div class="section-heading">
            <div>
                <p class="section-code">03 / SUMMARY</p>
                <h2>Current database numbers</h2>
            </div>
        </div>

        <div class="stats-panel">
            <div class="stat">
                <strong><?php echo $stats ? (int) $stats['total_events'] : 0; ?></strong>
                <span>Events</span>
            </div>

            <div class="stat">
                <strong><?php echo $stats ? (int) $stats['total_categories'] : 0; ?></strong>
                <span>Categories</span>
            </div>

            <div class="stat">
                <strong><?php echo $stats ? (int) $stats['total_seats'] : 0; ?></strong>
                <span>Available seats</span>
            </div>
        </div>
    </div>
</section>

<?php
mysqli_close($conn);
require 'includes/footer.php';
?>