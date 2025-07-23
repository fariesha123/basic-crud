<?php include '../db.php'; include '../shared/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone_no'];

    $stmt = $conn->prepare("INSERT INTO customer (name, address, phone_no) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $address, $phone);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>
<h2>Add Customer</h2>
<form method="post">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Address</label>
        <textarea name="address" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label>Phone No</label>
        <input type="text" name="phone_no" class="form-control" required>
    </div>
    <button class="btn btn-success">Save</button>
</form>
<?php include '../shared/footer.php'; ?>
