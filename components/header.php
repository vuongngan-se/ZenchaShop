<header class="header">
    <div class="flex">
        <a href="home.php" class="logo"><img src="img/logo.png"></a>
        <nav class="navbar">
            <a href="home.php">TRANG CHỦ</a>
            <a href="view_products.php">SẢN PHẨM</a>
            <a href="order.php">ĐẶT HÀNG</a>
            <a href="about.php">THÔNG TIN</a>
            <a href="contact.php">LIÊN HỆ</a>
            <a href="profile.php">THÔNG TIN TÀI KHOẢN</a>
        </nav>
        <div class="icons">
            <i class="bx bxs-user" id="user-btn" style="font-size: 25px;"></i>
            <?php
            // Đếm số lượng sản phẩm trong wishlist
            $count_wishlist_items = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id = '$user_id'");
            $total_wishlist_items = mysqli_num_rows($count_wishlist_items);
            ?>
            <a href="wishlist.php" class="cart-btn"><i class="bx bx-heart" style="font-size: 25px;"></i><sup><?= $total_wishlist_items ?></sup></a>
            <?php
            // Đếm số lượng sản phẩm trong cart
            $count_cart_items = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");
            $total_cart_items = mysqli_num_rows($count_cart_items);
            ?>
            <a href="cart.php" class="cart-btn"><i class="bx bx-cart-download" style="font-size: 25px;"></i><sup><?= $total_cart_items ?></sup></a>
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 25px;"></i>
        </div>

        <div class="user-box">
            <p>Tên người dùng :
                <span>
                    <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Chưa đăng nhập'; ?>
                </span>
            </p>
            <p>Email :
                <span>
                    <?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Chưa có email'; ?>
                </span>
            </p>

            <?php if (isset($_SESSION['user_id'])): ?>
                <form method="post" action="home.php">
                    <button type="submit" name="logout" class="logout-btn">Đăng xuất</button>
                </form>
            <?php else: ?>
                <a href="login.php" class="btn">Đăng nhập</a>
                <a href="register.php" class="btn">Đăng ký</a>
            <?php endif; ?>
        </div>
    </div>
</header>
