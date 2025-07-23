<?php include '../db.php'; include '../shared/header.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM customer WHERE customer_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone_no'];

    $update = $conn->prepare("UPDATE customer SET name=?, address=?, phone_no=? WHERE customer_id=?");
    $update->bind_param("sssi", $name, $address, $phone, $id);
    $update->execute();

    header("Location: index.php");
    exit;
}
?>
<h2>Edit Customer</h2>
<form method="post">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?= $customer['name'] ?>" required>
    </div>
    <div class="mb-3">
        <label>Address</label>
        <textarea name="address" class="form-control" required><?= $customer['address'] ?></textarea>
    </div>
    <div class="mb-3">
        <label>Phone No</label>
        <input type="text" name="phone_no" class="form-control" value="<?= $customer['phone_no'] ?>" required>
    </div>
    <button class="btn btn-primary">Update</button>
</form>
<?php include '../shared/footer.php'; ?>
