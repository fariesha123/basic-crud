<?php
include '../db.php';
include '../shared/header.php';
?>

<h2>Order List</h2>
<a href="create.php" class="btn btn-success mb-3">Create Order</a>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT orders.*, customer.name FROM orders
                JOIN customer ON orders.customer_id = customer.customer_id
                ORDER BY orders.order_id DESC";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()):
            $badgeClass = match ($row['status']) {
                'paid' => 'success',
                'cancelled' => 'danger',
                default => 'secondary'
            };
        ?>
            <tr>
                <td><?= $row['order_id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['order_date'] ?></td>
                <td><span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($row['status']) ?></span></td>
                <td>
                    <a href='view.php?id=<?= $row['order_id'] ?>' class='btn btn-info btn-sm'>View</a>
                    <a href='delete.php?id=<?= $row['order_id'] ?>' class='btn btn-danger btn-sm' onclick='return confirm("Are you sure?")'>Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../shared/footer.php'; ?>
