<?php
include '../db.php';
include '../shared/header.php';

// Fetch customers and products
$customers = $conn->query("SELECT * FROM customer");
$products = $conn->query("SELECT * FROM product");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $status = $_POST['status'];

    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, status) VALUES (?, ?)");
    $stmt->bind_param("is", $customer_id, $status);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Insert order details
    foreach ($_POST['product_id'] as $index => $product_id) {
        $qty = $_POST['quantity'][$index];
        if ($qty > 0) {
            $stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $order_id, $product_id, $qty);
            $stmt->execute();
        }
    }

    header("Location: index.php");
    exit;
}
?>

<h2>Create New Order</h2>

<form method="post">
    <!-- Customer -->
    <div class="mb-3">
        <label>Select Customer</label>
        <select name="customer_id" class="form-control" required>
            <option value="">-- Choose Customer --</option>
            <?php while ($c = $customers->fetch_assoc()): ?>
                <option value="<?= $c['customer_id'] ?>"><?= $c['name'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <!-- Status -->
    <div class="mb-3">
        <label>Order Status</label>
        <select name="status" class="form-control" required>
            <option value="pending">Pending</option>
            <option value="paid">Paid</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    <!-- Products -->
    <h5 class="mt-4">Select Products</h5>
    <?php while ($p = $products->fetch_assoc()): ?>
        <div class="row mb-2">
            <div class="col-md-6">
                <input type="hidden" name="product_id[]" value="<?= $p['product_id'] ?>">
                <label><?= $p['name'] ?> ($<?= $p['price'] ?>)</label>
            </div>
            <div class="col-md-6">
                <input type="number" name="quantity[]" value="0" min="0" class="form-control" placeholder="Quantity">
            </div>
        </div>
    <?php endwhile; ?>

    <button class="btn btn-primary mt-3">Place Order</button>
</form>

<?php include '../shared/footer.php'; ?>
