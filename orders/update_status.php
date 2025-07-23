<?php
include '../db.php';
$order_id = $_GET['id'];
$new_status = $_GET['status'];

$allowed = ['pending', 'paid', 'cancelled'];
if (in_array($new_status, $allowed)) {
    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE order_id=?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();
}
header("Location: index.php");
exit;
