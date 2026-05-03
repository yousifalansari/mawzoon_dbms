<?php
include '../../includes/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT Total_amount FROM ORDERS WHERE Order_ID=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result()->fetch_assoc();

echo $result['Total_amount'];