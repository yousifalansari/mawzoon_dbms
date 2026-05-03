<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<?php
$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM MENU_ITEM WHERE Item_ID=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();
?>

<div class="main">

<h1>Edit Menu Item</h1>

<form method="POST">
<input name="name" value="<?= $item['Item_name'] ?>" required>
<input name="category" value="<?= $item['Category'] ?>" required>
<input type="number" step="0.01" name="price" value="<?= $item['Price'] ?>" required>
<input name="description" value="<?= $item['Description'] ?>">

<button name="update">Update</button>
</form>

</div>

<?php
if (isset($_POST['update'])) {

    $stmt = $conn->prepare("
        UPDATE MENU_ITEM
        SET Item_name=?, Category=?, Price=?, Description=?
        WHERE Item_ID=?
    ");

    $stmt->bind_param("ssdsi",
        $_POST['name'],
        $_POST['category'],
        $_POST['price'],
        $_POST['description'],
        $id
    );

    $stmt->execute();

    header("Location: index.php");
}
?>

<?php include '../../includes/footer.php'; ?>