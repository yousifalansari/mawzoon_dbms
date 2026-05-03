<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<?php
// 🔒 Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT m.Item_name, c.Quantity, c.Unit_price
    FROM CONTAIN c
    JOIN MENU_ITEM m ON c.Item_ID = m.Item_ID
    WHERE c.Order_ID = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
?>

<div class="main">

<h1>Order Items</h1>

<table>
<tr>
    <th>Item</th>
    <th>Quantity</th>
    <th>Price</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?= htmlspecialchars($row['Item_name']) ?></td>
    <td><?= $row['Quantity'] ?></td>
    <td><?= $row['Unit_price'] ?></td>
</tr>
<?php } ?>

</table>

</div>

<?php include '../../includes/footer.php'; ?>