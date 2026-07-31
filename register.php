<?php
$pageTitle = 'Register';
require 'includes/db.php';

$errors = [];
$success = '';

$fullName = '';
$studentId = '';
$email = '';
$phone = '';
$college = '';
$academicLevel = '';
$selectedEvent = filter_input(INPUT_GET, 'event_id', FILTER_VALIDATE_INT);
$selectedEvent = $selectedEvent ? $selectedEvent : '';

$colleges = [
    'College of Computing',
    'College of Business',
    'College of Engineering',
    'College of Science',
    'College of Health Sciences',
    'College of Design',
    'College of Arts and Humanities'
];

$levels = [
    'First Year',
    'Second Year',
    'Third Year',
    'Fourth Year',
    'Fifth Year',
    'Postgraduate'
];

$events = [];
$eventsResult = mysqli_query(
    $conn,
    "SELECT id, title, event_date FROM events ORDER BY event_date ASC"
);

if ($eventsResult) {
    while ($row = mysqli_fetch_assoc($eventsResult)) {
        $events[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $studentId = strtoupper(trim($_POST['student_id'] ?? ''));
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $college = trim($_POST['college'] ?? '');
    $academicLevel = trim($_POST['academic_level'] ?? '');
    $selectedEvent = filter_var($_POST['event_id'] ?? '', FILTER_VALIDATE_INT);

    if ($fullName === '' || mb_strlen($fullName) < 3 || mb_strlen($fullName) > 120) {
        $errors[] = 'Enter a full name between 3 and 120 characters.';
    }

    if (!preg_match('/^S?\d{9}$/', $studentId)) {
        $errors[] = 'Enter a valid student ID with 9 digits and an optional S.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 120) {
        $errors[] = 'Enter a valid university email address.';
    } else {
        $emailDomain = strtolower(substr(strrchr($email, '@'), 1));

        if (
            substr($emailDomain, -4) !== '.edu' &&
            substr($emailDomain, -7) !== '.edu.sa'
        ) {
            $errors[] = 'Use a university email ending in .edu or .edu.sa.';
        }
    }

    if (!preg_match('/^(05\d{8}|\+9665\d{8})$/', $phone)) {
        $errors[] = 'Enter a Saudi mobile number such as 05XXXXXXXX or +9665XXXXXXXX.';
    }

    if (!in_array($college, $colleges, true)) {
        $errors[] = 'Choose a valid college or academic department.';
    }

    if (!in_array($academicLevel, $levels, true)) {
        $errors[] = 'Choose a valid academic level.';
    }

    $eventName = '';

    if (!$selectedEvent || $selectedEvent < 1) {
        $errors[] = 'Choose an event.';
    } else {
        $checkStmt = mysqli_prepare(
            $conn,
            "SELECT title, registration_deadline FROM events WHERE id = ?"
        );

        mysqli_stmt_bind_param($checkStmt, 'i', $selectedEvent);
        mysqli_stmt_execute($checkStmt);

        $checkResult = mysqli_stmt_get_result($checkStmt);
        $chosenEvent = mysqli_fetch_assoc($checkResult);

        if (!$chosenEvent) {
            $errors[] = 'The selected event does not exist.';
        } else {
            $eventName = $chosenEvent['title'];

            if ($chosenEvent['registration_deadline'] < date('Y-m-d')) {
                $errors[] = 'Registration for this event has closed.';
            }
        }

        mysqli_stmt_close($checkStmt);
    }

    if (empty($errors)) {
        $insertStmt = mysqli_prepare(
            $conn,
            "INSERT INTO registrations
            (full_name, student_id, email, phone, college, academic_level, event_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $insertStmt,
            'ssssssi',
            $fullName,
            $studentId,
            $email,
            $phone,
            $college,
            $academicLevel,
            $selectedEvent
        );

        if (mysqli_stmt_execute($insertStmt)) {
            $success = 'Your registration for ' . $eventName . ' was saved successfully.';

            $fullName = '';
            $studentId = '';
            $email = '';
            $phone = '';
            $college = '';
            $academicLevel = '';
            $selectedEvent = '';
        } else {
            $errors[] = 'The registration could not be saved. Please try again.';
        }

        mysqli_stmt_close($insertStmt);
    }
}

require 'includes/header.php';
?>

<section class="page-banner">
    <div class="shell">
        <p class="eyebrow">Registration form</p>
        <h1>Join a campus activity</h1>
        <p>PHP checks the submitted details before the registration is stored in MySQL.</p>
    </div>
</section>

<section class="section section-mint">
    <div class="shell">
        <div class="form-board">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error" role="alert">
                    <strong>Please correct the following:</strong>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success !== ''): ?>
                <div class="alert alert-success" role="status">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form action="register.php" method="post" novalidate>
                <div class="form-grid">
                    <div class="field">
                        <label for="full_name">Full name</label>
                        <input type="text" id="full_name" name="full_name"
                               maxlength="120" required
                               value="<?php echo htmlspecialchars($fullName); ?>">
                    </div>

                    <div class="field">
                        <label for="student_id">Student ID</label>
                        <input type="text" id="student_id" name="student_id"
                               maxlength="10" placeholder="S230045228" required
                               value="<?php echo htmlspecialchars($studentId); ?>">
                    </div>

                    <div class="field">
                        <label for="email">University email</label>
                        <input type="email" id="email" name="email"
                               maxlength="120" placeholder="student@university.edu.sa" required
                               value="<?php echo htmlspecialchars($email); ?>">
                    </div>

                    <div class="field">
                        <label for="phone">Saudi mobile number</label>
                        <input type="tel" id="phone" name="phone"
                               maxlength="14" placeholder="05XXXXXXXX" required
                               value="<?php echo htmlspecialchars($phone); ?>">
                    </div>

                    <div class="field">
                        <label for="college">College or department</label>
                        <select id="college" name="college" required>
                            <option value="">Choose a college</option>
                            <?php foreach ($colleges as $item): ?>
                                <option value="<?php echo htmlspecialchars($item); ?>"
                                    <?php echo $college === $item ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($item); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="field">
                        <label for="academic_level">Academic level</label>
                        <select id="academic_level" name="academic_level" required>
                            <option value="">Choose a level</option>
                            <?php foreach ($levels as $level): ?>
                                <option value="<?php echo htmlspecialchars($level); ?>"
                                    <?php echo $academicLevel === $level ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($level); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="field field-wide">
                        <label for="event_id">Selected event</label>
                        <select id="event_id" name="event_id" required>
                            <option value="">Choose an event</option>
                            <?php foreach ($events as $event): ?>
                                <option value="<?php echo (int) $event['id']; ?>"
                                    <?php echo ((string) $selectedEvent === (string) $event['id']) ? 'selected' : ''; ?>>
                                    <?php
                                    echo htmlspecialchars(
                                        $event['title'] . ' - ' . date('d M Y', strtotime($event['event_date']))
                                    );
                                    ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <button class="button" type="submit">Save registration</button>
            </form>
        </div>
    </div>
</section>

<?php
mysqli_close($conn);
require 'includes/footer.php';
?>
