<?php
include 'components/connection.php';
session_start();

// Kiểm tra quyền truy cập admin
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
    exit();
}

// Kiểm tra nếu idcmt được truyền qua URL
if (!isset($_GET['idcmt'])) {
    echo "<p>No product selected for viewing comments.</p>";
    exit();
}

$product_id = intval($_GET['idcmt']);

// Truy vấn lấy thông tin bình luận dựa vào id sản phẩm
$query = "SELECT id, user_id, comment, rating, date 
          FROM comments 
          WHERE product_id = $product_id 
          ORDER BY date DESC";


$comments = mysqli_query($conn, $query) or die('query failed');

// Truy vấn tên sản phẩm để hiển thị
$product_query = "SELECT name FROM products WHERE id = $product_id";
$product_result = mysqli_query($conn, $product_query) or die('query failed');
$product = mysqli_fetch_assoc($product_result);
$product_name = $product['name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments Management</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        <?php include 'style2.css'; ?>
    </style>
</head>
<body>
    <?php include 'components/admin_header.php'; ?>

    <section class="comment-management">
        <h1>Comments for Product: <?php echo $product_name; ?></h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Comment</th>
                    <th>Rating</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($comments) > 0) {
                    while ($comment = mysqli_fetch_assoc($comments)) {
                        echo "<tr>
                        <td>{$comment['id']}</td>
                        <td>{$comment['user_id']}</td>
                        <td>{$comment['comment']}</td>
                        <td>{$comment['rating']}</td>
                        <td>{$comment['date']}</td>
                        <td>
                            <a href='view_comment.php?delete={$comment['id']}&idcmt=$product_id' class='btn delete'>Delete</a>
                        </td>
                      </tr>";
                
                    }
                } else {
                    echo "<tr><td colspan='6'>No comments found for this product.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <?php
    // Xóa bình luận
    if (isset($_GET['delete'])) {
        $delete_id = intval($_GET['delete']);
        $delete_query = "DELETE FROM comments WHERE id = $delete_id";
        mysqli_query($conn, $delete_query) or die('query failed');
        header("location: view_comment.php?idcmt=$product_id");
        exit();
    }   
    ?>

</body>
</html>
