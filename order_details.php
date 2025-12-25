<?php
include 'components/connection.php';
session_start();



if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('location: login.php');
    exit();
}


if (isset($_GET['order_code'])) {
    $order_code = $_GET['order_code'];

    // Lấy thông tin đơn hàng
    $order_query = mysqli_query($conn, "SELECT * FROM orders WHERE order_code = '$order_code' AND user_id = '{$_SESSION['user_id']}'");

    // Kiểm tra nếu đơn hàng không tồn tại
    if (mysqli_num_rows($order_query) == 0) {
        echo "<script>alert('Đơn hàng không tồn tại!'); window.location='order.php';</script>";
        exit();
    }

    $order = mysqli_fetch_assoc($order_query);

    // Lấy chi tiết các sản phẩm trong đơn hàng
    $order_details_query = mysqli_query($conn, "SELECT * FROM order_details WHERE order_code = '$order_code'");
} else {
    header('location: order.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
      <?php include 'components/header.php'; ?>
</head>

<body>
  
    <div class="main">
        <div class="banner">
            <h1>Chi tiết đơn hàng</h1>
        </div>
        <div class="title2">
            <a href="order.php">Quay lại Lịch sử đơn hàng</a>
        </div>
        <section class="order-details">
            <div class="order-summary">
                <h2>Thông tin đơn hàng</h2>
                <p><strong>Mã đơn hàng:</strong> <?= $order['order_code']; ?></p>
                <p><strong>Tên khách hàng:</strong> <?= $order['name']; ?></p>
                <p><strong>Email:</strong> <?= $order['email']; ?></p>
                <p><strong>Số điện thoại:</strong> <?= $order['number']; ?></p>
                <p><strong>Địa chỉ:</strong> <?= $order['address']; ?></p>
                <p><strong>Loại địa chỉ:</strong> <?= $order['address_type']; ?></p>
                <p><strong>Phương thức thanh toán:</strong> <?= $order['method']; ?></p>
                <p><strong>Trạng thái:</strong> <?= $order['status'] === 'pending' ? 'Đang xác nhận' : 'Đã xác nhận'; ?></p>
            </div>
            <div class="order-products">
                <h2>Chi tiết sản phẩm</h2>
                <table border="1" cellspacing="0" cellpadding="10">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng cộng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $grand_total = 0;
                        while ($detail = mysqli_fetch_assoc($order_details_query)) {
                            $total = $detail['price'] * $detail['qty'];
                            $grand_total += $total;
                        ?>
                            <tr>
                                <td><?= $detail['name']; ?></td>
                                <td><?= $detail['qty']; ?></td>
                                <td><?= number_format($detail['price'], 2); ?> VNĐ</td>
                                <td><?= number_format($total, 2); ?> VNĐ</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="grand-total">
                    <h3>Tổng số tiền: <?= number_format($grand_total, 2); ?> VNĐ</h3>
                </div>
            </div>
        </section>
    </div>
    <?php include 'components/footer.php'; ?>
</body>
<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #fcf8e3;
    color: #5a4b41;
}

.main {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background: #fffdf7;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.banner {
    background-color: #8B4513;
    color: #fff;
    text-align: center;
    padding: 20px;
    border-radius: 8px 8px 0 0;
}

.banner h1 {
    margin: 0;
    font-size: 24px;
}

.title2 {
    margin: 20px 0;
    text-align: right;
}

.title2 a {
    text-decoration: none;
    color: #8B4513;
    font-weight: bold;
    border: 1px solid #8B4513;
    padding: 8px 12px;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.title2 a:hover {
    background-color: #8B4513;
    color: #fff;
}

.order-details {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
}

.order-summary,
.order-products {
    flex: 1;
    background-color: #fcf8e3;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.order-summary h2,
.order-products h2 {
    margin-top: 0;
    color: #8B4513;
}

.order-summary p {
    margin: 8px 0;
    line-height: 1.6;
}

.order-products table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.order-products table th,
.order-products table td {
    border: 1px solid #d4c29e;
    padding: 10px;
    text-align: left;
}

.order-products table th {
    background-color: #8B4513;
    color: #fff;
    font-weight: bold;
}

.order-products table tr:nth-child(even) {
    background-color: #fffaf0;
}

.order-products table tr:hover {
    background-color: #f5eddb;
}

.grand-total {
    text-align: right;
    margin-top: 20px;
}

.grand-total h3 {
    color: #8B4513;
    font-size: 18px;
}

</style>
</html>
