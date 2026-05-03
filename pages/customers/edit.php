<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<?php
// 🔒 Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// 🔍 Fetch customer safely
$stmt = $conn->prepare("SELECT * FROM CUSTOMER WHERE Customer_ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

// If not found → redirect
if (!$customer) {
    header("Location: index.php");
    exit();
}
?>

<div class="main">

<h1>Edit Customer</h1>

<form method="POST">

<input type="text" name="first" value="<?= htmlspecialchars($customer['First_name']) ?>" required>
<input type="text" name="last" value="<?= htmlspecialchars($customer['Last_name']) ?>" required>
<input type="text" name="phone" value="<?= htmlspecialchars($customer['Phone']) ?>" required>
<input type="email" name="email" value="<?= htmlspecialchars($customer['Email']) ?>" required>
<input type="text" name="address" value="<?= htmlspecialchars($customer['Address']) ?>">

<button type="submit" name="update">Update</button>

</form>

</div>

<?php
if (isset($_POST['update'])) {

    $stmt = $conn->prepare("
        UPDATE CUSTOMER
        SET First_name=?, Last_name=?, Phone=?, Email=?, Address=?
        WHERE Customer_ID=?
    ");

    $stmt->bind_param(
        "sssssi",
        $_POST['first'],
        $_POST['last'],
        $_POST['phone'],
        $_POST['email'],
        $_POST['address'],
        $id
    );

    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<?php include '../../includes/footer.php'; ?>