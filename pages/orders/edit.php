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
?>

<div class="main">

<h1>Edit Order</h1>

<form method="POST">

<label>Order Type:</label>
<select name="type">
    <option value="On-site">On-site</option>
    <option value="Delivery">Delivery</option>
</select>

<h3>New Items</h3>

<div id="items">
    <div>
        <select name="item_id[]">
            <?php
            $m = $conn->query("SELECT * FROM MENU_ITEM");
            while ($row = $m->fetch_assoc()) {
                echo "<option value='{$row['Item_ID']}'>"
                    . htmlspecialchars($row['Item_name']) .
                    " ({$row['Price']})</option>";
            }
            ?>
        </select>

        <input type="number" name="quantity[]" min="1" required>
    </div>
</div>

<button type="submit" name="update">Update Order</button>

</form>

</div>

<?php
if (isset($_POST['update'])) {

    $conn->begin_transaction();

    try {

        // Update type
        $stmt = $conn->prepare("UPDATE ORDERS SET Order_type=? WHERE Order_ID=?");
        $stmt->bind_param("si", $_POST['type'], $id);
        $stmt->execute();

        // Remove old items
        $stmt = $conn->prepare("DELETE FROM CONTAIN WHERE Order_ID=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Add new items
        for ($i = 0; $i < count($_POST['item_id']); $i++) {

            $item = $_POST['item_id'][$i];
            $qty = $_POST['quantity'][$i];

            // get price
            $price_q = $conn->prepare("SELECT Price FROM MENU_ITEM WHERE Item_ID=?");
            $price_q->bind_param("i", $item);
            $price_q->execute();
            $price = $price_q->get_result()->fetch_assoc()['Price'];

            $stmt = $conn->prepare("
                INSERT INTO CONTAIN (Order_ID, Item_ID, Quantity, Unit_price)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param("iiid", $id, $item, $qty, $price);
            $stmt->execute();
        }

        $conn->commit();

    } catch (Exception $e) {
        $conn->rollback();
    }

    header("Location: index.php");
    exit();
}
?>

<?php include '../../includes/footer.php'; ?>