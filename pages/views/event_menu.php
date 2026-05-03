<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Event Menu View</h1>

<table>
<tr>
    <th>Event</th>
    <th>Date</th>
    <th>Item</th>
    <th>Category</th>
    <th>Price</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM Event_Menu_View");

while ($row = $result->fetch_assoc()) {
?>
<tr>
    <td><?= htmlspecialchars($row['Event_name']) ?></td>
    <td><?= $row['Event_date'] ?></td>
    <td><?= htmlspecialchars($row['Item_name']) ?></td>
    <td><?= htmlspecialchars($row['Category']) ?></td>
    <td><?= $row['Price'] ?></td>
</tr>
<?php } ?>

</table>

</div>

<?php include '../../includes/footer.php'; ?>