<?php
include 'components/connection.php';
session_start();

// Check for admin privileges
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
    exit();
}

// Handle message deletion
if (isset($_GET['delete_message'])) {
    $delete_id = $_GET['delete_message'];
    $delete_query = mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('Query failed');
    header("location: admin_messages.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Messages</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style type="text/css">
        <?php include 'style2.css'; ?>
        .message-container {
            padding: 2rem;
        }
        .message-item {
            border: 1px solid #ddd;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .message-item p {
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }
        .message-item span {
            font-weight: bold;
            color: #6F4E37;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 5px;
            float: right;
        }
    </style>
</head>

<body>

    <?php include 'components/admin_header.php'; ?>

    <section class="message-container">
        <h1>Tin nhắn từ khách hàng</h1>
        
        <?php
        $select_messages = mysqli_query($conn, "SELECT * FROM `message` ORDER BY date DESC") or die('Query failed');
        if (mysqli_num_rows($select_messages) > 0) {
            while ($message = mysqli_fetch_assoc($select_messages)) {
        ?>
            <div class="message-item">
                <a href="admin_messages.php?delete_message=<?php echo $message['id']; ?>" class="delete-btn" onclick="return confirm('Bạn có chắc chắn muốn xóa tin nhắn này?');">Xóa</a>
                <p><span>Tên:</span> <?php echo $message['name']; ?></p>
                <p><span>Email:</span> <?php echo $message['email']; ?></p>
                <p><span>Số điện thoại:</span> <?php echo $message['number']; ?></p>
                <p><span>Nội dung:</span> <?php echo $message['message']; ?></p>
                <p><span>Ngày gửi:</span> <?php echo $message['date']; ?></p>
            </div>
        <?php
            }
        } else {
            echo "<p>Không có tin nhắn nào.</p>";
        }
        ?>
    </section>

</body>

</html>