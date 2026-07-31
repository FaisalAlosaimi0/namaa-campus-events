<?php
$pageTitle = 'About and Contact';

$errors = [];
$success = '';

$name = '';
$email = '';
$reason = '';
$subject = '';
$message = '';

$reasons = [
    'Event information',
    'Registration support',
    'Activity suggestion',
    'General feedback'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $reason = trim($_POST['reason'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || mb_strlen($name) < 3 || mb_strlen($name) > 100) {
        $errors[] = 'Enter a name between 3 and 100 characters.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 120) {
        $errors[] = 'Enter a valid email address.';
    }

    if (!in_array($reason, $reasons, true)) {
        $errors[] = 'Choose a valid contact reason.';
    }

    if ($subject === '' || mb_strlen($subject) < 3 || mb_strlen($subject) > 120) {
        $errors[] = 'Enter a subject between 3 and 120 characters.';
    }

    if ($message === '' || mb_strlen($message) < 10 || mb_strlen($message) > 1000) {
        $errors[] = 'Enter a message between 10 and 1000 characters.';
    }

    if (empty($errors)) {
        $success = 'The contact form passed server-side validation.';

        $name = '';
        $email = '';
        $reason = '';
        $subject = '';
        $message = '';
    }
}

require 'includes/header.php';
?>

    <section class="page-banner">
    <div class="shell">
        <p class="eyebrow">Office and Project Team</p>
        <h1>About Namaa</h1>
        <p>
            Namaa Campus Activities Office is a fictional Saudi university
            organization created for this academic web development project.
        </p>
    </div>
</section>

<section class="section">
    <div class="shell about-layout">
        <section class="paper">
            <h2>Office Purpose</h2>
            <p>
                Namaa collects activity information from different university
                groups and presents it through one clear event website.
                Students can read event details, check deadlines, and submit registrations.
            </p>

            <h2>Main Goals</h2>
            <ul>
                <li>Publish clear dates, times, locations, organizers, and intended audiences.</li>
                <li>Support educational, cultural, professional, wellbeing, environmental, and social events.</li>
                <li>Validate student information before saving it to the database.</li>
                <li>Provide a simple and organized platform for campus activities.</li>
            </ul>

            <h2>Project Team</h2>
            <div class="team-list">
                <div class="team-member">
                    <strong>Faisal Alosaimi</strong>
                    <span>S230045228</span>
                </div>

                <div class="team-member">
                    <strong>Hamzah Arif Alsaeedi</strong>
                    <span>S230016668</span>
                </div>

                <div class="team-member">
                    <strong>Rakan Mnaor Alotaibi</strong>
                    <span>S230054267</span>
                </div>
            </div>
        </section>

        <section class="paper">
            <h2>Contact Form</h2>
            <p> Complete the form below to contact the Namaa Campus Activities Office.</p>

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

            <form action="about.php" method="post" novalidate>
                <div class="field">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name"
                           maxlength="100" required
                           value="<?php echo htmlspecialchars($name); ?>">
                </div>

                <div class="field">
                    <label for="contact_email">Email</label>
                    <input type="email" id="contact_email" name="email"
                           maxlength="120" required
                           value="<?php echo htmlspecialchars($email); ?>">
                </div>

                <div class="field">
                    <label for="reason">Contact reason</label>
                    <select id="reason" name="reason" required>
                        <option value="">Choose a reason</option>
                        <?php foreach ($reasons as $item): ?>
                            <option value="<?php echo htmlspecialchars($item); ?>"
                                <?php echo $reason === $item ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($item); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="field">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject"
                           maxlength="120" required
                           value="<?php echo htmlspecialchars($subject); ?>">
                </div>

                <div class="field">
                    <label for="message">Message</label>
                    <textarea id="message" name="message"
                              maxlength="1000" required><?php echo htmlspecialchars($message); ?></textarea>
                </div>

                <button class="button" type="submit">Validate message</button>
            </form>
        </section>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
