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
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>ZenCha - Về Chúng Tôi</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Về Chúng Tôi</h1>
        </div>
        <div class="title2">
            <a href="home.php">Trang chủ</a><span>/ Chúng tôi</span>
        </div>
        <div class="about-category">
            <div class="box">
                <img src="img/unnamed (6).jpg">
                <div class="detail">
                    <a href="view_products.php" class="btn">Thấu Hiểu</a>
                </div>
            </div>
            <div class="box">
                <img src="img/unnamed (7).jpg">
                <div class="detail">
                    <a href="view_products.php" class="btn">Thưởng Trà</a>
                </div>
            </div>
            <div class="box">
                <img src="img/senchaa.jpg">
                <div class="detail">
                    <a href="view_products.php" class="btn">Thấu Hiểu</a>
                </div>
            </div>
            <div class="box">
                <img src="img/olong_.jpg">
                <div class="detail">
                    <a href="view_products.php" class="btn">Thưởng Trà</a>
                </div>
            </div>
        </div>
        <section class="services">
            <div class="title">
                <h1>Tại Sao Chọn Chúng Tôi</h1>
                <p>Triết Lý Pha Trà Của ZenCha</p>
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="img/icon2.png">
                    <div class="detail">
                        <h3>Tiết Kiệm Lớn</h3>
                        <p>Tiết kiệm lớn trong mỗi đơn hàng</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon1.png">
                    <div class="detail">
                        <h3>Hỗ Trợ 24/7</h3>
                        <p>Hỗ trợ tận tình một kèm một</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon0.png">
                    <div class="detail">
                        <h3>Phiếu Quà Tặng</h3>
                        <p>Nhận phiếu quà tặng vào mỗi dịp lễ hội</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon.png">
                    <div class="detail">
                        <h3>Giao Hàng Toàn Cầu</h3>
                        <p>Chúng tôi giao hàng đến khắp nơi trên thế giới</p>
                    </div>
                </div>
            </div>
        </section>
        <div class="about">
            <div class="row">
                <div class="img-box">
                    <img src="img/3.png" alt="">
                </div>
                <div class="detail">
                    <h1>Ghé Thăm Không Gian "Ichigo Ichie"</h1>
                    <p>Showroom của chúng tôi là hiện thân của triết lý "Ichigo Ichie" (Một lần gặp gỡ, không lặp lại), nơi mỗi buổi thưởng trà là duy nhất. Khám phá sự mộc mạc của Trà Việt và sự tinh tế của Trà Nhật, trong một không gian mang lại sự bình yên tuyệt đối.</p>
                    <a href="view_products.php" class="btn">Mua Ngay</a>
                </div>
            </div>
        </div>
        <div class="testimonial-container">
            <div class="title">
                <h1>Những Lời Thi Vị Từ Khách Hàng</h1>
                <p>Khách hàng của chúng tôi không chỉ thưởng thức trà, họ cảm nhận được triết lý mà ZenCha gửi gắm.</p>
            </div>
            <div class="container">
                <div class="testimonial-item active">
                    <img src="img/04.png">
                    <h1>Sara Smith</h1>
                    <p>Hương vị Matcha đã đưa tôi trở về Kyōto, còn Trà Sen lại khiến tôi nhớ Hà Nội. ZenCha là một hành trình kỳ diệu.</p>
                </div>
                <div class="testimonial-item">
                    <img src="img/02.jpg">
                    <h1>Jone Smith</h1>
                    <p>Không chỉ là trà, đó là sự thư thái tuyệt đối. ZenCha đã biến những khoảnh khắc bận rộn của tôi thành những buổi thiền định ngắn ngủi.</p>
                </div>
                <div class="testimonial-item">
                    <img src="img/03.jpg">
                    <h1>Selena Smith</h1>
                    <p>Cánh trà giữ nguyên độ tươi mới, và sự chăm sóc khách hàng cũng tinh tế như một nghi thức Trà Đạo. Tuyệt vời!</p>
                </div>
                <div class="left-arrow" onclick="nextSlide()"><i class="bx bxs-left-arrow-alt"></i></div>
                <div class="right-arrow" onclick="prevSlide()"><i class="bx bxs-right-arrow-alt"></i></div>
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