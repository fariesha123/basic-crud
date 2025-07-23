<?php include '../db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM customer WHERE customer_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit;
