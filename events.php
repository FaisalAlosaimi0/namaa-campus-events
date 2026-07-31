<?php
$pageTitle = 'Events';
require 'includes/db.php';

$eventsResult = mysqli_query(
    $conn,
    "SELECT * FROM events ORDER BY event_date ASC, event_time ASC"
);

require 'includes/header.php';
?>

<section class="page-banner">
    <div class="shell">
        <p class="eyebrow">Campus bulletin</p>
        <h1>All upcoming activities</h1>
        <p>
            Compare the date, category, location, and short description before
            opening the full event record.
        </p>
    </div>
</section>

<section class="section">
    <div class="shell">
        <?php if ($eventsResult && mysqli_num_rows($eventsResult) > 0): ?>
            <div class="bulletin-list">
                <?php while ($event = mysqli_fetch_assoc($eventsResult)): ?>
                    <article class="bulletin">
                        <div class="bulletin-date">
                            <strong><?php echo date('d', strtotime($event['event_date'])); ?></strong>
                            <span><?php echo date('M Y', strtotime($event['event_date'])); ?></span>
                        </div>

                        <img src="<?php echo htmlspecialchars($event['image']); ?>"
                             alt="<?php echo htmlspecialchars($event['title']); ?>">

                        <div class="bulletin-copy">
                            <span class="ticket"><?php echo htmlspecialchars($event['category']); ?></span>
                            <h2><?php echo htmlspecialchars($event['title']); ?></h2>
                            <p><?php echo htmlspecialchars($event['short_description']); ?></p>

                            <ul class="event-meta">
                                <li><strong>Time:</strong> <?php echo date('g:i A', strtotime($event['event_time'])); ?></li>
                                <li><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></li>
                            </ul>

                            <a class="button button-light" href="event.php?id=<?php echo (int) $event['id']; ?>">
                                Read details
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h2>No events found</h2>
                <p>The events table is currently empty.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
mysqli_close($conn);
require 'includes/footer.php';
?>
