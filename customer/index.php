<?php include '../db.php'; include '../shared/header.php'; ?>
<h2>Customer List</h2>
<a href="create.php" class="btn btn-success mb-3">Add Customer</a>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th><th>Name</th><th>Address</th><th>Phone</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $conn->query("SELECT * FROM customer");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['customer_id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['address']}</td>
                <td>{$row['phone_no']}</td>
                <td>
                    <a href='edit.php?id={$row['customer_id']}' class='btn btn-sm btn-warning'>Edit</a>
                    <a href='delete.php?id={$row['customer_id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </td>
            </tr>";
        }
        ?>
    </tbody>
</table>
<?php include '../shared/footer.php'; ?>