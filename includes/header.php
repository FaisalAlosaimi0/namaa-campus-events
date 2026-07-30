<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Campus Events Hub';
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | Campus Events Hub</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="announcement">
    <div class="shell">
        <p>Student activities calendar · Namaa Campus Activities Office</p>
    </div>
</div>

<header class="site-header">
    <div class="shell header-row">
        <a class="brand" href="index.php" aria-label="Campus Events Hub home">
            <span class="brand-shape">N</span>
            <span>
                <strong>Namaa Campus Events</strong>
                <small>Campus Events Hub</small>
            </span>
        </a>

        <nav class="nav-box" aria-label="Main navigation">
            <a class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a>
            <a class="<?php echo in_array($currentPage, ['events.php', 'event.php']) ? 'active' : ''; ?>" href="events.php">Events</a>
            <a class="<?php echo $currentPage === 'register.php' ? 'active' : ''; ?>" href="register.php">Register</a>
            <a class="<?php echo $currentPage === 'registrations.php' ? 'active' : ''; ?>" href="registrations.php">Registrations</a>
            <a class="<?php echo $currentPage === 'about.php' ? 'active' : ''; ?>" href="about.php">About</a>
        </nav>
    </div>
</header>
<main>
