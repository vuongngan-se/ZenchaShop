<header class="header">
    <div class="flex">
        <!-- Logo -->
        <a href="admin_dashboard.php" class="logo">
            <img src="img/logo4.png" alt="Admin Logo" class="logo-img">
        </a>

        <!-- Thanh điều hướng dành cho admin -->
        <nav class="navbar">
            <a href="admin_dashboard.php">DASHBOARD</a>
            <a href="admin_manage_products.php">QUẢN LÝ SẢN PHẨM</a>
            <a href="admin_categories.php">DANH MỤC</a>
            <a href="admin_orders.php">ĐƠN HÀNG</a>
            <a href="admin_users.php">NGƯỜI DÙNG</a>
        </nav>

        <!-- Các icon và thông tin admin -->
        <div class="icons">
            <i class="bx bxs-user" id="user-btn" style="font-size: 25px;"></i>
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 25px;"></i>
        </div>

        <!-- Hộp thông tin admin -->
        <div class="user-box">
            <p>Tên admin:
                <span>
                    <?php echo isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Chưa đăng nhập'; ?>
                </span>
            </p>
            <p>Email:
                <span>
                    <?php echo isset($_SESSION['admin_email']) ? $_SESSION['admin_email'] : 'Chưa có email'; ?>
                </span>
            </p>

            <?php if (isset($_SESSION['admin_id'])): ?>
                <form method="post" action="admin_dashboard.php">
                    <button type="submit" name="logout" class="logout-btn">Đăng xuất</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</header>
<script>
    const userBtn = document.getElementById('user-btn');
    const userBox = document.querySelector('.user-box');

    // Mở/đóng hộp thông tin admin khi nhấn icon
    userBtn.addEventListener('click', function() {
        userBox.classList.toggle('active');
    });

    // Đóng hộp thông tin admin khi click bên ngoài
    document.addEventListener('click', function(e) {
        if (!userBox.contains(e.target) && e.target !== userBtn) {
            userBox.classList.remove('active');
        }
    });
</script>