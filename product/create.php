<?php include '../db.php'; include '../shared/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO product (name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $name, $price);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>
<h2>Add Product</h2>
<form method="post">
    <div class="mb-3">
        <label>Product Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Price</label>
        <input type="number" step="0.01" name="price" class="form-control" required>
    </div>
    <button class="btn btn-success">Save</button>
</form>
<?php include '../shared/footer.php'; ?>
