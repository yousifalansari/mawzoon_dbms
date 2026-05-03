<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Orders</h1>

<a href="add.php">
    <button>Create Order</button>
</a>

<table>
<tr>
    <th>ID</th>
    <th>Type</th>
    <th>Status</th>
    <th>Total</th>
    <th>Actions</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM ORDERS");

while ($row = $result->fetch_assoc()) {
?>
<tr>
    <td><?= $row['Order_ID'] ?></td>
    <td><?= htmlspecialchars($row['Order_type']) ?></td>
    <td><?= htmlspecialchars($row['Status']) ?></td>
    <td><?= $row['Total_amount'] ?></td>
    
      <td class="actions">
    <a href="view_items.php?id=<?= $row['Order_ID'] ?>" class="btn view">View</a>
    <a href="edit.php?id=<?= $row['Order_ID'] ?>" class="btn edit">Edit</a>
    <a href="delete.php?id=<?= $row['Order_ID'] ?>" class="btn delete"
       onclick="return confirm('Delete this order?')">Delete</a>
    </td>
</tr>
<?php } ?>

</table>

</div>

<?php include '../../includes/footer.php'; ?>   