<?php
include '../db.php';
include '../shared/header.php';

$id = $_GET['id'];

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE order_id=?");
    $stmt->bind_param("si", $new_status, $id);
    $stmt->execute();
    header("Location: view.php?id=$id"); // Refresh to reflect changes
    exit;
}

// Fetch order info
$order = $conn->query("SELECT * FROM orders WHERE order_id = $id")->fetch_assoc();
$customer = $conn->query("SELECT * FROM customer WHERE customer_id = {$order['customer_id']}")->fetch_assoc();

// Fetch order details
$details = $conn->query("
    SELECT od.*, p.name, p.price
    FROM order_details od
    JOIN product p ON od.product_id = p.product_id
    WHERE od.order_id = $id
");

// Badge color
$badgeClass = match ($order['status']) {
    'paid' => 'success',
    'cancelled' => 'danger',
    default => 'secondary'
};
?>

<h2>Order #<?= $order['order_id'] ?> Details</h2>

<div class="mb-3">
    <strong>Customer:</strong> <?= $customer['name'] ?><br>
    <strong>Order Date:</strong> <?= $order['order_date'] ?><br>

    <!-- Editable Status -->
    <form method="post" class="mt-2">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <label class="form-label mb-0"><strong>Status:</strong></label>
            </div>
            <div class="col-auto">
                <select name="status" class="form-select">
                    <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="paid" <?= $order['status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
                    <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary btn-sm">Update</button>
            </div>
        </div>
    </form>
</div>

<!-- Order Items -->
<table class="table table-bordered mt-4">
    <thead class="table-light">
        <tr><th>Product</th><th>Price</th><th>Qty</th><th>Total</th></tr>
    </thead>
    <tbody>
        <?php
        $grand = 0;
        while ($row = $details->fetch_assoc()):
            $total = $row['price'] * $row['quantity'];
            $grand += $total;
        ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td>$<?= number_format($row['price'], 2) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td>$<?= number_format($total, 2) ?></td>
            </tr>
        <?php endwhile; ?>
        <tr>
            <th colspan="3" class="text-end">Grand Total:</th>
            <th>$<?= number_format($grand, 2) ?></th>
        </tr>
    </tbody>
</table>

<a href="index.php" class="btn btn-secondary mt-3">Back to Orders</a>

<?php include '../shared/footer.php'; ?>
