<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/db.php'; ?>

<div class="main">

<h1>Add Menu Item</h1>

<form method="POST">
<input name="name" placeholder="Item Name" required>
<input name="category" placeholder="Category" required>
<input type="number" step="0.01" name="price" placeholder="Price" required>
<input name="description" placeholder="Description">

<button name="add">Add</button>
</form>

</div>

<?php
if (isset($_POST['add'])) {

    $stmt = $conn->prepare("
        INSERT INTO MENU_ITEM (Item_name, Category, Price, Description)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("ssds",
        $_POST['name'],
        $_POST['category'],
        $_POST['price'],
        $_POST['description']
    );

    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<?php include '../../includes/footer.php'; ?>