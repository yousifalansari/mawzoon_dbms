<?php include '../../includes/auth.php'; ?>
<?php include '../../includes/db.php'; ?>

<?php
$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM MENU_ITEM WHERE Item_ID=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit();
?>