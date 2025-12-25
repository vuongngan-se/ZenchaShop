<?php
include 'components/connection.php';
session_start();

// Kiểm tra quyền truy cập admin
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
    exit();
}

// Lấy mã order_code từ URL
if (isset($_GET['order_code'])) {
    $order_code = $_GET['order_code'];

    // Truy vấn thông tin đơn hàng chính từ bảng `orders`
    $order_query = mysqli_query($conn, "SELECT * FROM orders WHERE order_code = '$order_code'") or die('Query failed');
    $order = mysqli_fetch_assoc($order_query);

    // Truy vấn chi tiết đơn hàng từ bảng `order_detail`
    $order_details_query = mysqli_query($conn, "SELECT * FROM order_details WHERE order_code = '$order_code'") or die('Query failed');
} else {
    header("location: admin_manage_orders.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style type="text/css">
        <?php include 'style2.css'; ?>
    </style>
</head>

<body>

    <?php include 'components/admin_header.php'; ?>

    <section class="order-details">
        <h1>Order Details</h1>

        <?php if ($order): ?>
            <h2>Order Summary</h2>
            <p><strong>Order Code:</strong> <?= $order['order_code']; ?></p>
            <p><strong>User ID:</strong> <?= $order['user_id']; ?></p>
            <p><strong>Name:</strong> <?= $order['name']; ?></p>
            <p><strong>Email:</strong> <?= $order['email']; ?></p>
            <p><strong>Date:</strong> <?= $order['date']; ?></p>
            <p><strong>Status:</strong> <?= $order['status'] == 'pending' ? 'Pending' : 'Confirmed'; ?></p>

            <h3>Products in Order</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grand_total = 0;
                    while ($detail = mysqli_fetch_assoc($order_details_query)) {
                        $total_price = $detail['price'] * $detail['qty'];
                        $grand_total += $total_price;
                        echo "<tr>
                            <td>{$detail['product_id']}</td>
                            <td>{$detail['name']}</td>
                            <td>{$detail['qty']}</td>
                            <td>{$detail['price']}</td>
                            <td>{$total_price}</td>
                          </tr>";
                    }
                    ?>
                    <tr>
                        <td colspan="4"><strong>Grand Total</strong></td>
                        <td><strong>$<?= number_format($grand_total, 2); ?></strong></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p>No order details found.</p>
        <?php endif; ?>
    </section>

</body>

</html>