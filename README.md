# Basic-CRUD

## Overview

This project provides a basic CRUD (Create, Read, Update, Delete) system using PHP (MySQLi) and MySQL with simple mockup ordering.

## CRUD Operation

- create.php – create or add new for data records
- read.php - read data records
- update.php – Update existing records.
- delete.php – Delete records.

for manage customer, manage products and manage orders.

## Database & Data:

- copy query from files `sql-query-clean.sql` and paste into your db and run by the query.
- import files from `sql-phpadmin.sql` into your db and connect it.

## Setup & Configuration (DB)

Edit db.php to match your hosting

```
<?php
$host = 'localhost';
$user = 'root'; // // default MySQL user
$pass = ''; // // default MySQL password (empty)
$db = 'order_system';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```
