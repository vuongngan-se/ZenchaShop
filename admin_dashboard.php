<?php
include_once 'components/connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style type="text/css">
        <?php include 'style2.css'; ?>body {
            background: url("img/body-bg.jpg");
            width: 100%;
        }
    </style>
</head>

<body class="dashboard">

    <?php include 'components/admin_header.php'; ?>

    <div class="dashboard-container">
        <h1>Admin Dashboard</h1>
        <h2>ZenCha - Trà Việt & Nhật Bản</h2>
        <p>Chào mừng bạn đến vơi Admin Dashboard</p>

        <div class="dashboard-buttons">
            <a href="admin_manage_products.php"><i class='bx bx-store'></i>Quản lý sản phẩm</a>
            <a href="admin_orders.php"><i class='bx bx-cart'></i>Đơn hàng</a>
            <a href="admin_users.php"><i class='bx bx-user'></i>Users</a>
            <a href="admin_categories.php"><i class='bx bx-category'></i>Quản lý danh mục</a>
            <a href="login.php"><i class='bx bx-log-out'></i>Đăng xuất</a>
        </div>

    </div>

</body>

</html>