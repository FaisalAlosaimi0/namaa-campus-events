<?php
$pageTitle = 'Registrations';
require 'includes/db.php';

$registrationsResult = mysqli_query(
    $conn,
    "SELECT
        registrations.full_name,
        registrations.student_id,
        registrations.email,
        registrations.phone,
        registrations.college,
        registrations.academic_level,
        registrations.registration_date,
        events.title AS event_title
     FROM registrations
     INNER JOIN events ON registrations.event_id = events.id
     ORDER BY registrations.registration_date DESC"
);

require 'includes/header.php';
?>

<section class="page-banner">
    <div class="shell">
        <p class="eyebrow">Academic database view</p>
        <h1>Saved registrations</h1>
        <p>This page joins registration records with their selected event titles.</p>
    </div>
</section>

<section class="section">
    <div class="shell">
        <?php if ($registrationsResult && mysqli_num_rows($registrationsResult) > 0): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Student ID</th>
                            <th>University Email</th>
                            <th>Saudi Mobile</th>
                            <th>College</th>
                            <th>Academic Level</th>
                            <th>Event</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($registration = mysqli_fetch_assoc($registrationsResult)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($registration['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($registration['student_id']); ?></td>
                                <td><?php echo htmlspecialchars($registration['email']); ?></td>
                                <td><?php echo htmlspecialchars($registration['phone']); ?></td>
                                <td><?php echo htmlspecialchars($registration['college']); ?></td>
                                <td><?php echo htmlspecialchars($registration['academic_level']); ?></td>
                                <td><?php echo htmlspecialchars($registration['event_title']); ?></td>
                                <td><?php echo date('d M Y, g:i A', strtotime($registration['registration_date'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h2>No registrations saved</h2>
                <p>Valid student registrations will appear here after they are inserted.</p>
                <a class="button" href="register.php">Open registration form</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
mysqli_close($conn);
require 'includes/footer.php';
?>
