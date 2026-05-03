<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Menu Items</h1>

<a href="add.php"><button>Add Item</button></a>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Category</th>
    <th>Price</th>
    <th>Description</th>
    <th>Actions</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM MENU_ITEM");

while ($row = $result->fetch_assoc()) {
?>
<tr>
    <td><?= $row['Item_ID'] ?></td>
    <td><?= htmlspecialchars($row['Item_name']) ?></td>
    <td><?= htmlspecialchars($row['Category']) ?></td>
    <td><?= $row['Price'] ?></td>
    <td><?= htmlspecialchars($row['Description']) ?></td>
    <td>
        <a href="edit.php?id=<?= $row['Item_ID'] ?>"><button>Edit</button></a>
        <a href="delete.php?id=<?= $row['Item_ID'] ?>" onclick="return confirm('Delete item?')">
            <button>Delete</button>
        </a>
    </td>
</tr>
<?php } ?>

</table>

</div>

<?php include '../../includes/footer.php'; ?>