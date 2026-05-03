<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Create Order</h1>

<form method="POST">

<label>Customer:</label>
<select name="customer_id" required>
<?php
$c = $conn->query("SELECT * FROM CUSTOMER");
while ($row = $c->fetch_assoc()) {
    echo "<option value='{$row['Customer_ID']}'>"
        . htmlspecialchars($row['First_name'] . " " . $row['Last_name']) .
        "</option>";
}
?>
</select>

<label>Event:</label>
<select name="event_id" required>
<?php
$e = $conn->query("SELECT * FROM EVENTS");
while ($row = $e->fetch_assoc()) {
    echo "<option value='{$row['Event_ID']}'>"
        . htmlspecialchars($row['Event_name']) .
        "</option>";
}
?>
</select>

<label>Order Type:</label>
<select name="type">
    <option value="On-site">On-site</option>
    <option value="Delivery">Delivery</option>
</select>

<h3>Items</h3>

<div id="items">

    <div class="item" style="margin-bottom:10px;">
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

        <input type="number" name="quantity[]" placeholder="Quantity" min="1" required>

        <button type="button" onclick="removeItem(this)">❌</button>
    </div>

</div>

<button type="button" onclick="addItem()">+ Add Another Item</button>

<br><br>
<button type="submit" name="create">Create Order</button>

</form>

</div>

<script>
function addItem() {
    let div = document.createElement("div");
    div.className = "item";
    div.style.marginBottom = "10px";

    div.innerHTML = `
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

        <input type="number" name="quantity[]" placeholder="Quantity" min="1" required>

        <button type="button" onclick="removeItem(this)">❌</button>
    `;

    document.getElementById("items").appendChild(div);
}

function removeItem(button) {
    let itemDiv = button.parentElement;

    if (document.querySelectorAll("#items .item").length > 1) {
        itemDiv.remove();
    } else {
        alert("At least one item is required.");
    }
}
</script>

<?php
if (isset($_POST['create'])) {

    $conn->begin_transaction();

    try {

        // 1. Create order
        $stmt = $conn->prepare("
            INSERT INTO ORDERS (Order_type, Order_time, Status)
            VALUES (?, NOW(), 'Pending')
        ");
        $stmt->bind_param("s", $_POST['type']);
        $stmt->execute();

        $order_id = $conn->insert_id;

        // 2. Link customer
        $stmt = $conn->prepare("INSERT INTO PLACES VALUES (?, ?)");
        $stmt->bind_param("ii", $_POST['customer_id'], $order_id);
        $stmt->execute();

        // 3. Link event
        $stmt = $conn->prepare("INSERT INTO HOSTS VALUES (?, ?)");
        $stmt->bind_param("ii", $_POST['event_id'], $order_id);
        $stmt->execute();

        // 4. Insert items
        $items = $_POST['item_id'];
        $qtys = $_POST['quantity'];

        for ($i = 0; $i < count($items); $i++) {

            // get price
            $price_q = $conn->prepare("SELECT Price FROM MENU_ITEM WHERE Item_ID = ?");
            $price_q->bind_param("i", $items[$i]);
            $price_q->execute();
            $price = $price_q->get_result()->fetch_assoc()['Price'];

            $stmt = $conn->prepare("
                INSERT INTO CONTAIN (Order_ID, Item_ID, Quantity, Unit_price)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param("iiid", $order_id, $items[$i], $qtys[$i], $price);
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