<?php include '../db.php'; include '../shared/header.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM product WHERE product_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $update = $conn->prepare("UPDATE product SET name=?, price=? WHERE product_id=?");
    $update->bind_param("sdi", $name, $price, $id);
    $update->execute();

    header("Location: index.php");
    exit;
}
?>
<h2>Edit Product</h2>
<form method="post">
    <div class="mb-3">
        <label>Product Name</label>
        <input type="text" name="name" class="form-control" value="<?= $product['name'] ?>" required>
    </div>
    <div class="mb-3">
        <label>Price</label>
        <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?>" required>
    </div>
    <button class="btn btn-primary">Update</button>
</form>
<?php include '../shared/footer.php'; ?>
