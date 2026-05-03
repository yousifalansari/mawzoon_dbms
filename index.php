<?php
session_start();

// 🔒 If already logged in → go to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: pages/dashboard/");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mawzoon Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="centered">

<div class="auth-card">
    <h2>Login</h2>

    <?php if (isset($_GET['error'])) echo "<p style='color:red;'>Invalid login</p>"; ?>

    <form method="POST" action="pages/auth/login.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account?</p>
    <a href="pages/auth/register.php">
        <button type="button">Register</button>
    </a>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>