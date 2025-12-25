<?php
include 'components/connection.php';
session_start();

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin người dùng
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
if (mysqli_num_rows($query) > 0) {
    $user = mysqli_fetch_assoc($query);
    $name = $user['name'];
    $email = $user['email'];
} else {
    header('location: login.php');
    exit();
}

// Xử lý đổi mật khẩu
if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu cũ
    if (password_verify($old_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            // Hash mật khẩu mới và cập nhật
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE users SET password = '$hashed_password' WHERE id = '$user_id'");
            $success_msg = "Mật khẩu đã được đổi thành công!";
        } else {
            $error_msg = "Mật khẩu mới và xác nhận không khớp!";
        }
    } else {
        $error_msg = "Mật khẩu cũ không đúng!";
    }
}
?>
<style type="text/css">
    <?php include 'style.css'; ?>
    /* Thêm style CSS đặc biệt cho profile nếu cần (style đã có trong file gốc) */
    .profile-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #d4c29e;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
    }

    .profile-container h1, .profile-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile-container p {
        font-size: 16px;
        margin: 10px 0;
    }

    .profile-container form {
        margin-top: 20px;
    }

    .profile-container form label {
        display: block;
        margin: 10px 0 5px;
        font-weight: bold;
        color: #5a4b41;
    }

    .profile-container form input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #d4c29e;
        border-radius: 5px;
    }

    .profile-container form button {
        width: 100%;
        padding: 10px;
        background-color: #8B4513;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .profile-container form button:hover {
        background-color: #A0522D;
    }

    .success {
        color: green;
        text-align: center;
    }

    .error {
        color: red;
        text-align: center;
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Thông tin tài khoản</title>
    </head>

<body>
    
    <?php include 'components/header.php'; ?>
    <div class="main">
    <div class="profile-container">
        <br><br>
        <h1>Thông tin tài khoản</h1>
        <p><strong>Họ tên:</strong> <?= htmlspecialchars($name); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($email); ?></p>

        <h2>Đổi mật khẩu</h2>
        <form method="POST">
            <label for="old_password">Mật khẩu cũ:</label>
            <input type="password" name="old_password" required>

            <label for="new_password">Mật khẩu mới:</label>
            <input type="password" name="new_password" required>

            <label for="confirm_password">Xác nhận mật khẩu:</label>
            <input type="password" name="confirm_password" required>

            <button type="submit" name="change_password">Đổi mật khẩu</button>
        </form>
        <?php
        if (isset($success_msg)) {
            echo "<p class='success'>$success_msg</p>";
        }
        if (isset($error_msg)) {
            echo "<p class='error'>$error_msg</p>";
        }
        ?>
    </div>

    <?php include 'components/footer.php'; ?>
    <?php include 'ai_chatbox.php'; ?>
    </div>
</body>

</html>