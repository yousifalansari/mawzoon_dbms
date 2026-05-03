<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Order Details View</h1>

<table>
<tr>
    <th>Order ID</th>
    <th>Type</th>
    <th>Time</th>
    <th>Status</th>
    <th>Customer</th>
    <th>Payment Method</th>
    <th>Amount Paid</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM Order_Details_View");

while ($row = $result->fetch_assoc()) {
?>
<tr>
    <td><?= $row['Order_ID'] ?></td>
    <td><?= htmlspecialchars($row['Order_type']) ?></td>
    <td><?= $row['Order_time'] ?></td>
    <td><?= htmlspecialchars($row['Order_Status']) ?></td>
    <td><?= htmlspecialchars($row['First_name'] . " " . $row['Last_name']) ?></td>
    <td><?= htmlspecialchars($row['Payment_method'] ?? 'N/A') ?></td>
    <td><?= $row['Amount_paid'] ?? 'N/A' ?></td>
</tr>
<?php } ?>

</table>

</div>

<?php include '../../includes/footer.php'; ?>