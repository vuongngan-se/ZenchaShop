<?php
include 'components/connection.php'; // Kết nối cơ sở dữ liệu
session_start(); // Bắt đầu session

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
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $cpass = mysqli_real_escape_string($conn, $_POST['cpass']);
    $user_type = 'user'; // Mặc định là người dùng bình thường

    // Kiểm tra xem email đã tồn tại chưa
    $check_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($check_user) > 0) {
        echo '<script>
            alert("Email đã tồn tại! Vui lòng thử email khác.");
        </script>';
    } elseif ($pass != $cpass) {
        echo '<script>
            alert("Mật khẩu xác nhận không khớp!");
        </script>';
    } else {
        // Mã hóa mật khẩu trước khi lưu
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

        // Thêm người dùng mới vào cơ sở dữ liệu (không cần chèn id, vì nó tự động tăng)
        $insert_user = "INSERT INTO `users` (name, email, password, user_type) 
                        VALUES ('$name', '$email', '$hashed_pass', '$user_type')";

        if (mysqli_query($conn, $insert_user)) {
            // Lấy id của người dùng vừa được tạo
            $user_id = mysqli_insert_id($conn);

            // Lưu thông tin đăng nhập vào session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_type'] = $user_type;

            // Chuyển hướng đến trang chủ sau khi đăng ký thành công
            echo '<script>
                alert("Đăng ký thành công!");
                window.location.href = "home.php";
            </script>';
        } else {
            echo '<script>
                alert("Đã xảy ra lỗi! Vui lòng thử lại.");
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
    <title>ZenCha - Đăng ký ngay</title>
</head>

<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="img/download.png">
                <h1>Đăng ký ngay</h1>
                <p>Hãy đăng ký tài khoản để tận hưởng nhiều ưu đãi</p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>Tên của bạn *</p>
                    <input type="text" name="name" required placeholder="Nhập tên của bạn" maxlength="50">
                </div>
                <div class="input-field">
                    <p>Email của bạn *</p>
                    <input type="email" name="email" required placeholder="Nhập email của bạn" maxlength="50"
                        oninput="this.value =this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>Mật khẩu của bạn *</p>
                    <input type="password" name="pass" required placeholder="Nhập mật khẩu của bạn" maxlength="50"
                        oninput="this.value =this.value.replace(/\s/g, '')">
                </div>

                <div class="input-field">
                    <p>Xác nhận mật khẩu *</p>
                    <input type="password" name="cpass" required placeholder="Nhập lại mật khẩu của bạn" maxlength="50"
                        oninput="this.value =this.value.replace(/\s/g, '')">
                </div>
                <input type="submit" name="submit" value="Đăng ký ngay" class="btn">
                <p>Bạn đã có tài khoản ?<a href="login.php"> Đăng nhập ngay</a></p>
            </form>
        </section>
    </div>
</body>

</html>