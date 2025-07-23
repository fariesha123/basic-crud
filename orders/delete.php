<?php include '../db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM order_details WHERE order_id = $id");
$conn->query("DELETE FROM orders WHERE order_id = $id");

header("Location: index.php");
exit;
