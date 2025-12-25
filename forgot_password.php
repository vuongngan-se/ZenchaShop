<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Chỉ cần nếu dùng Composer

include 'components/connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['forgot_submit'])) {
        // Gửi mã xác nhận đến email
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $query = "SELECT * FROM `users` WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $verification_code = rand(100000, 999999); // Tạo mã xác nhận ngẫu nhiên
            $expire_time = date('Y-m-d H:i:s', strtotime('+20 minutes'));


            // Lưu mã xác nhận vào CSDL
            $update_query = "UPDATE `users` SET reset_token = '$verification_code', reset_token_expire = '$expire_time' WHERE email = '$email'";
            mysqli_query($conn, $update_query);

            // Gửi email với PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'nganvuonglebao@gmail.com'; // Email của bạn
                $mail->Password = '12345678';   // Mật khẩu ứng dụng
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('your_email@gmail.com', 'Zencha Shop');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'XAC NHAN DAT LAI MAT KHAU';
                $mail->Body = "Chào bạn,<br><br>Đây là mã xác nhận của bạn: <b>$verification_code</b><br>Mã này có hiệu lực trong 10 phút.";

                $mail->send();
                echo '<script>alert("Mã xác nhận đã được gửi đến email của bạn.");</script>';
            } catch (Exception $e) {
                echo "Không thể gửi email. Lỗi: {$mail->ErrorInfo}";
            }
        } else {
            echo '<script>alert("Email không tồn tại!");</script>';
        }
    } elseif (isset($_POST['verify_submit'])) {
        //  Xác nhận mã và đặt lại mật khẩu
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $code = mysqli_real_escape_string($conn, $_POST['code']);
        $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

        $query = "SELECT * FROM `users` WHERE email = '$email' AND reset_token = '$code' AND reset_token_expire > NOW()";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Cập nhật mật khẩu mới
            $update_query = "UPDATE `users` SET password = '$new_password', reset_token = NULL, reset_token_expire = NULL WHERE email = '$email'";
            mysqli_query($conn, $update_query);

            echo '<script>alert("Mật khẩu của bạn đã được đặt lại thành công!"); window.location.href = "login.php";</script>';
        } else {
            echo '<script>alert("Mã xác nhận không hợp lệ hoặc đã hết hạn!");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-container"> 
        <section class="form-container"> 
            <div class="title">
                <img src="img/download.png">
                <h1>Quên mật khẩu</h1>
                <p>Vui lòng nhập email và làm theo hướng dẫn để đặt lại mật khẩu.</p>
            </div>
            <!-- Form gửi mã xác nhận -->
            <form action="" method="post">
                <div class="input-field">
                    <p>Email của bạn *</p>
                    <input type="email" name="email" required placeholder="Nhập email của bạn">
                </div>
                <button type="submit" name="forgot_submit" class="btn">Gửi mã xác nhận</button>
            </form>
            
            <!-- Form xác nhận mã và đặt lại mật khẩu -->
            <form action="" method="post">
                <div class="input-field">
                    <p>Nhập lại email của bạn *</p>
                    <input type="email" name="email" required placeholder="Nhập email của bạn">
                </div>
                <div class="input-field">
                    <p>Mã xác nhận *</p>
                    <input type="text" name="code" required placeholder="Nhập mã xác nhận">
                </div>
                <div class="input-field">
                    <p>Mật khẩu mới *</p>
                    <input type="password" name="new_password" required placeholder="Nhập mật khẩu mới">
                </div>
                <button type="submit" name="verify_submit" class="btn">Đặt lại mật khẩu</button>
            </form>
            <p><a href="login.php">Quay lại trang chủ</a></p>
        </section>
    </div>
</body>
</html>
