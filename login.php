<?php
include 'components/connection.php'; // Kết nối cơ sở dữ liệu
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $role = isset($_POST['role']) ? $_POST['role'] : 'user'; // Lấy giá trị của lựa chọn Admin/User

    if ($role == 'admin') {
        // Đăng nhập cho Admin với email và mật khẩu cố định
        $admin_email = 'nganmy@gmail.com';
        $admin_password = '123';

        if ($email == $admin_email && $pass == $admin_password) {
            // Lưu thông tin vào session
            $_SESSION['admin_id'] = 1;
            $_SESSION['admin_name'] = 'Admin';
            $_SESSION['admin_email'] = $admin_email;

            echo '<script>
                alert("Đăng nhập admin thành công!");
                window.location.href = "admin_dashboard.php"; // Trang admin
            </script>';
        } else {
            echo '<script>
                alert("Thông tin đăng nhập Admin không chính xác!");
            </script>';
        }
    } else {
        // Đăng nhập cho User thông thường
        $query = "SELECT * FROM `users` WHERE email = '$email'";
        $result = mysqli_query($conn, $query) or die('query failed');

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($pass, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_type'] = 'user';

                echo '<script>
                    alert("Đăng nhập thành công!");
                    window.location.href = "home.php"; // Trang user
                </script>';
            } else {
                echo '<script>
                    alert("Mật khẩu không chính xác!");
                </script>';
            }
        } else {
            echo '<script>
                alert("Email không tồn tại!");
            </script>';
        }
    }
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
    <title>ZenCha - Đăng nhập</title>
</head>

<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <h1>Đăng nhập ngay</h1>
                <p>Chào mừng đến với ZenCha! Vui lòng chọn vai trò đăng nhập của bạn dưới đây.</p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>Email của bạn *</p>
                    <input type="email" name="email" required placeholder="Nhập email của bạn" maxlength="50"
                        oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>Mật khẩu *</p>
                    <input type="password" name="pass" required placeholder="Nhập mật khẩu của bạn" maxlength="50"
                        oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>Đăng nhập với:</p>
                    <div><br></div>
                    <label class="custom-radio">
                        <input type="radio" name="role" value="user" checked>
                        <span class="radio-label">User</span>
                    </label>
                    <label class="custom-radio">
                        <input type="radio" name="role" value="admin">
                        <span class="radio-label">Admin</span>
                    </label>
                </div>
                <div><br></div>

                <input type="submit" name="submit" value="Đăng nhập ngay" class="btn">
                
                <p>Bạn chưa có tài khoản ? <a href="register.php">Đăng ký ngay</a> / <a href="forgot_password.php">Quên mật khẩu</a></p>

            </form>
        </section>
    </div>


</body>


</html>