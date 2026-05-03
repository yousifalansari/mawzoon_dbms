<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Add Payment</h1>

<form method="POST">

<label>Select Order:</label>
<select name="order_id" required>
<?php
$result = $conn->query("SELECT Order_ID FROM ORDERS WHERE Status != 'Paid'");
while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['Order_ID']}'>Order #{$row['Order_ID']}</option>";
}
?>
</select>

<label>Payment Method:</label>
<select name="method">
    <option value="Cash">Cash</option>
    <option value="Card">Card</option>
</select>

<button type="submit" name="pay">Submit Payment</button>

</form>

</div>

<?php
if (isset($_POST['pay'])) {

    $order_id = $_POST['order_id'];
    $method = $_POST['method'];
    $status = "Completed";

    // 🔥 Get total amount from ORDERS
    $stmt_total = $conn->prepare("
        SELECT Total_amount FROM ORDERS WHERE Order_ID = ?
    ");
    $stmt_total->bind_param("i", $order_id);
    $stmt_total->execute();
    $result = $stmt_total->get_result()->fetch_assoc();

    // Safety check
    if (!$result) {
        header("Location: index.php");
        exit();
    }

    $amount = $result['Total_amount'];

    // ✅ Insert payment using system-calculated amount
    $stmt = $conn->prepare("
        INSERT INTO PAYMENT (Order_ID, Payment_method, Amount_paid, Payment_time, Status)
        VALUES (?, ?, ?, NOW(), ?)
    ");

    $stmt->bind_param(
        "isds",
        $order_id,
        $method,
        $amount,
        $status
    );

    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<?php include '../../includes/footer.php'; ?>