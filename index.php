<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-content">
            <h1>Dashboard </h1>
            <!-- <a href="logout.php" class="logout-btn" onclick="return confirm('Apakah Anda yakin ingin logout?')">Log Out</a> -->
        </div>
    </header>

    <!-- Main Content -->
    <main class="container">
        <section class="dashboard-buttons">
            <a href="dbconnection.php" class="dashboard-button">connection</a>
            <a href="get_materi.php" class="dashboard-button">get materi</a>
            <a href="loginuser.php" class="dashboard-button">login</a>
            <a href="update_progressmateri.php" class="dashboard-button">progress</a>
            <a href="video_api.php" class="dashboard-button">Video</a>
        </section>
    </main>
</body>
</html>
