<?php
session_start();
include '../../includes/db.php';

// 🔒 If already logged in → go to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard/");
    exit();
}

$message = "";

// Handle register
if (isset($_POST['register'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    // ❌ Password mismatch
    if ($password !== $confirm) {
        $message = "<p style='color:red;'>Passwords do not match</p>";
    } else {

        // 🔍 Check if email exists in STAFF
        $stmt = $conn->prepare("SELECT Staff_ID FROM STAFF WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $staff = $result->fetch_assoc();

        if (!$staff) {
            $message = "<p style='color:red;'>Email not found in staff records</p>";
        } else {

            $staff_id = $staff['Staff_ID'];

            // 🚫 Check duplicate username
            $check = $conn->prepare("SELECT User_ID FROM USERS WHERE Username = ?");
            $check->bind_param("s", $username);
            $check->execute();

            if ($check->get_result()->num_rows > 0) {
                $message = "<p style='color:red;'>Username already taken</p>";
            } else {

                // 🔐 Hash password
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // ✅ Insert user
                $stmt = $conn->prepare("
                    INSERT INTO USERS (Username, Email, Password_hash, Staff_ID)
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->bind_param("sssi", $username, $email, $hash, $staff_id);

                if ($stmt->execute()) {
                    $message = "<p style='color:green;'>Registered successfully. You can now log in.</p>";
                } else {
                    $message = "<p style='color:red;'>Error occurred during registration</p>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="centered">

<div class="auth-card">

    <h2>Register</h2>

    <?= $message ?>

    <form method="POST">

        <input type="text" name="username" placeholder="Username" required>

        <input type="email" name="email" placeholder="Email (must match staff email)" required>

        <input type="password" name="password" placeholder="Password" required>

        <input type="password" name="confirm" placeholder="Confirm Password" required>

        <button type="submit" name="register">Register</button>

    </form>

    <p>Already have an account?</p>
    <a href="../../index.php">
        <button type="button">Login</button>
    </a>

</div>

<?php include '../../includes/footer.php'; ?>

</body>
</html>