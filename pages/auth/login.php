<?php
session_start();
include '../../includes/db.php';

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("
        SELECT u.*, s.First_name 
        FROM USERS u
        LEFT JOIN STAFF s ON u.Staff_ID = s.Staff_ID
        WHERE u.Username = ?
    ");

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['Password_hash'])) {

        $_SESSION['user_id'] = $user['User_ID'];
        $_SESSION['username'] = $user['Username'];
        $_SESSION['name'] = $user['First_name'];

        header("Location: ../dashboard/");
        exit();

    } else {
        header("Location: ../../index.php?error=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="centered">

<div class="auth-card">
    <h2>Login</h2>

    <p style="color:red;">Invalid username or password</p>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account?</p>
    <a href="register.php">
        <button type="button">Register</button>
    </a>
</div>

<?php include '../../includes/footer.php'; ?>

</body>
</html>