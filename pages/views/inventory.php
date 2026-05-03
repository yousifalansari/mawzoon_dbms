<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Inventory Status View</h1>

<table>
<tr>
    <th>Ingredient</th>
    <th>Quantity</th>
    <th>Reorder Level</th>
    <th>Status</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM Inventory_Status_View");

while ($row = $result->fetch_assoc()) {

    $low = $row['Quantity_available'] <= $row['Reorder_level'];
?>
<tr style="<?= $low ? 'background-color:#ffcccc;' : '' ?>">
    <td><?= htmlspecialchars($row['Ingredient_name']) ?></td>
    <td><?= $row['Quantity_available'] ?></td>
    <td><?= $row['Reorder_level'] ?></td>
    <td><?= $low ? '<strong style="color:red;">LOW</strong>' : 'OK' ?></td>
</tr>
<?php } ?>

</table>

</div>

<?php include '../../includes/footer.php'; ?>