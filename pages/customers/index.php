<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Customers</h1>

<a href="add.php">
    <button>Add Customer</button>
</a>

<p style="color:gray;">
Customers cannot be deleted to preserve historical order data.
</p>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Address</th>
    <th>Actions</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM CUSTOMER");

while ($row = $result->fetch_assoc()) {
?>
<tr>
    <td><?= $row['Customer_ID'] ?></td>
    <td><?= htmlspecialchars($row['First_name'] . " " . $row['Last_name']) ?></td>
    <td><?= htmlspecialchars($row['Phone']) ?></td>
    <td><?= htmlspecialchars($row['Email']) ?></td>
    <td><?= htmlspecialchars($row['Address']) ?></td>

    <td>
        <a href="edit.php?id=<?= $row['Customer_ID'] ?>">
            <button>Edit</button>
        </a>
    </td>
</tr>
<?php } ?>

</table>

</div>

<?php include '../../includes/footer.php'; ?>