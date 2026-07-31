<?php
$pageTitle = 'Event Details';
require 'includes/db.php';

$event = null;
$eventId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($eventId && $eventId > 0) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM events WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $eventId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $event = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
}

if ($event) {
    $pageTitle = $event['title'];
}

require 'includes/header.php';
?>

<section class="page-banner">
    <div class="shell">
        <p class="eyebrow"><?php echo $event ? htmlspecialchars($event['category']) : 'Event details'; ?></p>
        <h1><?php echo $event ? htmlspecialchars($event['title']) : 'Event not found'; ?></h1>
        <p>
            <?php
            echo $event
                ? htmlspecialchars($event['short_description'])
                : 'The supplied event ID is missing, invalid, or unavailable.';
            ?>
        </p>
    </div>
</section>

<section class="section">
    <div class="shell">
        <?php if ($event): ?>
            <article class="detail-grid">
                <div class="detail-image">
                    <img src="<?php echo htmlspecialchars($event['image']); ?>"
                         alt="<?php echo htmlspecialchars($event['title']); ?>">
                </div>

                <div class="detail-panel">
                    <h2>Event facts</h2>

                    <ul class="fact-list">
                        <li><strong>Date:</strong> <?php echo date('l, d F Y', strtotime($event['event_date'])); ?></li>
                        <li><strong>Time:</strong> <?php echo date('g:i A', strtotime($event['event_time'])); ?></li>
                        <li><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></li>
                        <li><strong>Organizer:</strong> <?php echo htmlspecialchars($event['organizer']); ?></li>
                        <li><strong>Available seats:</strong> <?php echo (int) $event['available_seats']; ?></li>
                        <li><strong>Registration deadline:</strong> <?php echo date('d M Y', strtotime($event['registration_deadline'])); ?></li>
                        <li><strong>Intended audience:</strong> <?php echo htmlspecialchars($event['intended_audience']); ?></li>
                    </ul>

                    <h2>Activity description</h2>
                    <p><?php echo nl2br(htmlspecialchars($event['full_description'])); ?></p>

                    <a class="button" href="register.php?event_id=<?php echo (int) $event['id']; ?>">
                        Register for this event
                    </a>
                </div>
            </article>
        <?php else: ?>
            <div class="empty-state">
                <h2>Unable to display this event</h2>
                <p>Return to the events page and select a valid activity.</p>
                <a class="button" href="events.php">Back to events</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
mysqli_close($conn);
require 'includes/footer.php';
?>
