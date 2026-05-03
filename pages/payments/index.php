<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Payments</h1>

<a href="add.php">
    <button>Add Payment</button>
</a>

<table>
<tr>
    <th>ID</th>
    <th>Order ID</th>
    <th>Amount</th>
    <th>Method</th>
    <th>Status</th>
    <th>Time</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM PAYMENT ORDER BY Payment_time DESC");

while ($row = $result->fetch_assoc()) {
?>
<tr>
    <td><?= $row['Payment_ID'] ?></td>
    <td><?= $row['Order_ID'] ?></td>
    <td><?= number_format($row['Amount_paid'], 2) ?></td>
    <td><?= htmlspecialchars($row['Payment_method']) ?></td>
    <td><?= htmlspecialchars($row['Status']) ?></td>
    <td><?= $row['Payment_time'] ?></td>
</tr>
<?php } ?>

</table>

</div>

<?php include '../../includes/footer.php'; ?>