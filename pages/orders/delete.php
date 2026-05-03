<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/db.php'; ?>

<?php
// 🔒 Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$order_id = $_GET['id'];

$conn->begin_transaction();

try {

    // 1. Delete order items
    $stmt = $conn->prepare("DELETE FROM CONTAIN WHERE Order_ID = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    // 2. Delete customer link
    $stmt = $conn->prepare("DELETE FROM PLACES WHERE Order_ID = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    // 3. Delete event link
    $stmt = $conn->prepare("DELETE FROM HOSTS WHERE Order_ID = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    // 4. Delete payment (if exists)
    $stmt = $conn->prepare("DELETE FROM PAYMENT WHERE Order_ID = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    // 5. Delete delivery (if exists)
    $stmt = $conn->prepare("DELETE FROM DELIVERY WHERE Order_ID = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    // 6. Delete order
    $stmt = $conn->prepare("DELETE FROM ORDERS WHERE Order_ID = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    $conn->commit();

} catch (Exception $e) {
    $conn->rollback();
}

// 🔁 Redirect back to orders list
header("Location: index.php");
exit();
?>