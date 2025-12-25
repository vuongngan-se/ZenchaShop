<?php
include 'components/connection.php';
session_start();
// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
if (isset($_POST['logout'])) {
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
    
    <title>Zencha - Trà Việt & Nhật Bản - Trang Chủ</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">

        <section class="home-section">
            <div class="custom-slider-wrapper">
                <div class="custom-slider">
                    <div class="container">
                        <div class="slide">
                            <div class="item" style="background-image: url('img/unnamed (5).jpg');">
                                <div class="content">
                                    <h1>Chào mừng bạn đến với Zencha: Nơi Giao Thoa Cảm Hứng Trà Á Đông</h1>
                                    <p>Khám phá hương vị thiền tịnh của Matcha Nhật và sự thanh thoát của Trà Việt.</p>
                                    <a href="view_products.php" class="btn">Mua ngay</a>
                                </div>
                            </div>
                            <div class="item" style="background-image: url('img/unnamed (4).jpg');">
                                <div class="content">
                                    <h1>Tỉnh Thức Trong Từng Ngụm Trà Sen</h1>
                                    <p>Thưởng thức nét duyên Hà Thành, hương sen ướp mộc tinh tế.</p>
                                    <a href="view_products.php" class="btn">Khám phá ngay</a>
                                </div>
                            </div>
                            <div class="item" style="background-image: url('img/unnamed (2).jpg');">
                                <div class="content">
                                    <h1>Uống Trà, Sống Thiền: Matcha Tinh Luyện</h1>
                                    <p>Năng lượng xanh nguyên bản, tinh hoa từ đất trời Nhật Bản.</p>
                                    <a href="view_products.php" class="btn">Mua ngay</a>
                                </div>
                            </div>
                            <div class="item" style="background-image: url('img/unnamed (3).jpg');">
                                <div class="content">
                                    <h1>Zencha - Chạm Tới Sự Bình Yên</h1>
                                    <p>Đơn giản là thưởng thức, sảng khoái mỗi ngày.</p>
                                    <a href="view_products.php" class="btn">Xem ngay</a>
                                </div>
                            </div>
                            <div class="item" style="background-image: url('img/04.jpg'); ">
                                <div class="content">
                                    <h1>Zencha - Chất Lượng Vàng, Giá Trị Thật</h1>
                                    <p>Thức uống vì sức khỏe và sự an yên của bạn.</p>
                                    <a href="view_products.php" class="btn">Thử ngay</a>
                                </div>
                            </div>
                        </div>

                        <div class="buttonn">
                            <button class="prev"><i class="fa-solid fa-arrow-left"></i></button>
                            <button class="next"><i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--- home slide end--->
        <section class="thumb">
            <div class='box-container'>
                <div class="box">
                    <img src="img/matcha.jpg">
                    <h3>Matcha Tĩnh Lặng</h3>
                    <p>Năng lượng xanh từ Nhật Bản, đánh thức sự tập trung và an yên.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="box">
                    <img src="img/unnamed.jpg">
                    <h3>Trà Sen Thanh Cao</h3>
                    <p>Nét duyên Hà Thành, hương sen ướp mộc tinh tế và sang trọng.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="box">
                    <img src="img/sencha.jpg">
                    <h3>Sencha Truyền Thống</h3>
                    <p>Thức uống năng lượng tự nhiên, đốt cháy mỡ thừa.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="box">
                    <img src="img/olong.jpg">
                    <h3>Trà Ô Long Tuyết</h3>
                    <p>Từng búp trà xanh nguyên bản, mang lại cảm giác sảng khoái tức thì.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
            </div>
        </section>
        <section class="container">
            
                <div class="box">
                    <img src="img/logo1.jpg">
                </div>
                <div class="box">
                    <span>Zencha: Hơn Cả Một Thức Uống</span>
                    <h1>Giảm đến 50% cho trà truyền thống</h1>
                    <p>Trà là nhịp cầu kết nối văn hóa. Tại Zencha, chúng tôi mang đến sự cân bằng: thanh lọc cơ thể, nuôi dưỡng tinh thần và kéo dài tuổi thọ.</p>
                </div>
                
        </section>
        <section class="shop">
            <div class="title">
                <h1> Tuyển Tập Thịnh Hành - Được Yêu Thích Nhất </h1>
            </div>
            <div class="row">
                    <img src="img/unnamed (1).jpg" style="width: 100%; height: auto;">
            </div>

        </section>
        </section>
        <section class="shop-category">
            <div class="box-container">
                <div class="box">
                    <img src="img/van-hoa-tra-dao-nhat-dao-1.jpg">
                    <div class="detail">
                        <span>THỜI KHẮC VÀNG</span>
                        <h1>Ưu Đãi Đặc Biệt Cho Trà Nhật Cao Cấp</h1>
                        <a href="view_products.php" class="btn">Mua ngay</a>
                    </div>
                </div>
                <div class="box">
                    <img src="img/van-hoa-tra-dao-nhat-ban-1.jpg">
                    <div class="detail">
                        <span>MỘT CHÚT VIỆT</span>
                        <h1>Khám phá Hương Vị Trà Truyền Thống</h1>
                        <a href="view_products.php" class="btn"> Mua ngay</a>
                    </div>
                </div>
            </div>
        </section>
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

        <?php include 'components/footer.php'; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <script>
        let next = document.querySelector('.next');
        let prev = document.querySelector('.prev');

        next.addEventListener('click', function() {
            let items = document.querySelectorAll('.item');
            document.querySelector('.slide').appendChild(items[0]);
        });

        prev.addEventListener('click', function() {
            let items = document.querySelectorAll('.item');
            document.querySelector('.slide').prepend(items[items.length - 1]);
        });

        setInterval(function() {
            next.click();
        }, 3000);
    </script>
    <?php include 'components/alert.php'; ?>
    <?php
include 'ai_chatbox.php';
?>


</body>

</html>