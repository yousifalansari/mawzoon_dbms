<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Inventory</h1>

<table>
<tr>
    <th>ID</th>
    <th>Ingredient</th>
    <th>Unit</th>
    <th>Quantity</th>
    <th>Reorder Level</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM INVENTORY");

while ($row = $result->fetch_assoc()) {

    $low = $row['Quantity_available'] <= $row['Reorder_level'];
?>
<tr style="<?= $low ? 'background-color:#ffcccc;' : '' ?>">
    <td><?= $row['Inventory_ID'] ?></td>
    <td><?= htmlspecialchars($row['Ingredient_name']) ?></td>
    <td><?= htmlspecialchars($row['Unit']) ?></td>
    <td><?= $row['Quantity_available'] ?></td>
    <td><?= $row['Reorder_level'] ?></td>
    <td>
        <?= $low ? '<strong style="color:red;">LOW</strong>' : 'OK' ?>
    </td>
    <td>
        <a href="update.php?id=<?= $row['Inventory_ID'] ?>">
            <button>Restock</button>
        </a>
    </td>
</tr>
<?php } ?>

</table>

</div>

<?php include '../../includes/footer.php'; ?>