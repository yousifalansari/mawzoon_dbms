<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Get ingredient
$stmt = $conn->prepare("SELECT * FROM INVENTORY WHERE Inventory_ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$item = $stmt->get_result()->fetch_assoc();

if (!$item) {
    header("Location: index.php");
    exit();
}
?>

<div class="main">

<h1>Restock Ingredient</h1>

<p><strong><?= htmlspecialchars($item['Ingredient_name']) ?></strong></p>

<form method="POST">

<label>Add Quantity (<?= htmlspecialchars($item['Unit']) ?>):</label>
<input type="number" name="amount" min="1" required>

<button type="submit" name="update">Update</button>

</form>

</div>

<?php
if (isset($_POST['update'])) {

    $stmt = $conn->prepare("
        UPDATE INVENTORY
        SET Quantity_available = Quantity_available + ?
        WHERE Inventory_ID = ?
    ");

    $stmt->bind_param("ii", $_POST['amount'], $id);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<?php include '../../includes/footer.php'; ?>