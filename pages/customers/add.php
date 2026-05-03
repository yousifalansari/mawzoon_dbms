<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Add Customer</h1>

<form method="POST">

<input type="text" name="first" placeholder="First Name" required>
<input type="text" name="last" placeholder="Last Name" required>
<input type="text" name="phone" placeholder="Phone" required>
<input type="email" name="email" placeholder="Email" required>
<input type="text" name="address" placeholder="Address">

<button type="submit" name="add">Add</button>

</form>

</div>

<?php
if (isset($_POST['add'])) {

    $stmt = $conn->prepare("
        INSERT INTO CUSTOMER (First_name, Last_name, Phone, Email, Address)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssss",
        $_POST['first'],
        $_POST['last'],
        $_POST['phone'],
        $_POST['email'],
        $_POST['address']
    );

    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<?php include '../../includes/footer.php'; ?>