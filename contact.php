<?php
include 'components/connection.php';
session_start();
// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
if (isset($_SESSION['logout'])) {
    session_destroy();
    header("location: login.php");
}
?>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Zencha - Liên hệ</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Liên hệ với chúng tôi</h1>
        </div>
        <div class="title2">
            <a href="home.php">home</a><span>/ liên hệ với chúng tôi</span>
        </div>

        <section class="services">
            <div class="box-container">
                <div class="box">
                    <img src="img/icon2.png">
                    <div class="detail">
                        <h3>Săn Deal Tinh Tế</h3>
                        <p>Ưu đãi tốt nhất cho những người sành trà</p>
                    </div>

                </div>
                <div class="box">
                    <img src="img/icon1.png">
                    <div class="detail">
                        <h3>Tư Vấn Chuyên Sâu</h3>
                        <p>Hỗ trợ trực tuyến 24/7 về trà và cách pha</p>
                    </div>

                </div>
                <div class="box">
                    <img src="img/icon0.png">
                    <div class="detail">
                        <h3>Quà Tặng An Nhiên</h3>
                        <p>Voucher đặc biệt vào các dịp lễ hội trà</p>
                    </div>

                </div>
                <div class="box">
                    <img src="img/icon.png">
                    <div class="detail">
                        <h3>Giao Trà Khắp Nơi</h3>
                        <p>Vận chuyển nhanh chóng, bảo quản chất lượng trà</p>
                    </div>

                </div>
            </div>

        </section>
        <div class="form-container">
            <form method="post">
                <div class="title">
                    <h1>Để lại tin nhắn</h1>
                </div>
                <div class="input-field">
                    <p>tên của bạn *</p>
                    <input type="text" name="name">
                </div>
                <div class="input-field">
                    <p>email của bạn *</p>
                    <input type="email" name="email">
                </div>
                <div class="input-field">
                    <p>số của bạn *</p>
                    <input type="text" name="number">
                </div>
                <div class="input-field">
                    <p>your message *</p>
                    <textarea name="message"></textarea>
                </div>
                <button type="submit" name="submit-btn" class="btn">send message</button>
            </form>

        </div>
        <div class="address">
            <div class="title">
                <h1>chi tiết liên lạc</h1>
                <p>ZenCha - Trà Việt & Nhật Bản<p>
            </div>
            <div class="box-container">
                <div class="box">
                    <i class="bx bxs-map-pin"></i>
                    <div>
                        <h4>Địa chỉ</h4>
                        <p>Hòa Hải, Đà Nẵng</p>
                    </div>
                </div>
                <div class="box">
                    <i class="bx bxs-phone-call"></i>
                    <div>
                        <h4>Số điện thoại </h4>
                        <p>0908070605</p>
                    </div>
                </div>
                <div class="box">
                    <i class="bx bxs-map-pin"></i>
                    <div>
                        <h4>email</h4>
                        <p>nganvlb.24ns@gmail.com</p>
                        <p>mypnt.24ns@gmail.com<p>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'components/footer.php'; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
    <?php include 'ai_chatbox.php'; ?>
</body>

</html>