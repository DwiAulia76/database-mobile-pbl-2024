<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="web/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="logo">
                <img src="logo.png" alt="Logo" width="100">
            </div>
            <h2>LOGIN ADMIN</h2>
            <form action="web/login.php" method="post">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit">Sign In</button>
            </form>
            <a href="forgot-password.php" class="forgot-link">Forgot password?</a>
        </div>
    </div>
</body>
</html>
