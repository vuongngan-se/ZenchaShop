<?php
include 'components/connection.php';
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('location: login.php');
    exit();
}

// Lấy tất cả các đơn hàng của người dùng, sắp xếp theo ngày đặt hàng từ mới đến cũ
$order_query = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY date DESC");

?>
<!DOCTYPE html>
<html lang="en">

<style type="text/css">
    <?php include 'style.css'; ?>
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>ZenCha - Lịch sử đơn hàng</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Lịch sử đặt hàng</h1> 
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/ Lịch sử đặt hàng</span>
        </div>
        <section class="order-history">
            <div class="title">
                <h1>Danh sách đơn hàng của bạn</h1>
            </div>
            <?php if (mysqli_num_rows($order_query) > 0) { ?>
                <?php while ($order = mysqli_fetch_assoc($order_query)) { ?>
                    <div class="order-details">
                        <h3>Tóm tắt đơn hàng</h3>
                        <p><strong>ID đơn hàng:</strong> <?= $order['order_code']; ?></p>
                        <p><strong>Tên:</strong> <?= $order['name']; ?></p>
                        <p><strong>Số điện thoại:</strong> <?= $order['number']; ?></p>
                        <p><strong>Email:</strong> <?= $order['email']; ?></p>
                        <p><strong>Địa chỉ:</strong> <?= $order['address']; ?></p>
                        <p><strong>Loại địa chỉ:</strong> <?= $order['address_type']; ?></p>
                        <p><strong>Phương thức thanh toán</strong> <?= $order['method']; ?></p>

                        <!-- Hiển thị trạng thái đơn hàng -->
                        <p><strong>Trạng thái:</strong>
                            <?php
                            if ($order['status'] === 'pending') {
                                echo 'Đang xác nhận';
                            } elseif ($order['status'] === 'confirmed') {
                                echo 'Đã xác nhận';
                            } elseif ($order['status'] === 'canceled') {
                                echo 'Đã hủy';
                            }
                            ?>
                        </p>


                        <?php
                        // Tính tổng tiền của từng đơn hàng
                        $order_code = $order['order_code'];
                        $order_details_query = mysqli_query($conn, "SELECT price, qty FROM order_details WHERE order_code = '$order_code'");
                        $grand_total = 0;
                        while ($detail = mysqli_fetch_assoc($order_details_query)) {
                            $grand_total += $detail['price'] * $detail['qty'];
                        }
                        ?>
                        <div class="total-amount">Tổng số tiền: <?= number_format($grand_total, 2); ?> VNĐ</div>
                        <a href="order_details.php?order_code=<?= $order['order_code']; ?>" class="view-order-btn">Xem chi tiết</a>
                    </div>
                    <hr>
                <?php } ?>
            <?php } else { ?>
                <p>Không tìm thấy đơn hàng nào!</p>
            <?php } ?>
        </section>

        <?php include 'components/footer.php'; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
    <?php include 'ai_chatbox.php'; ?>
</body>
<style>
    
</style>
</html>