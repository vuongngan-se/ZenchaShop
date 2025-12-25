<?php
include 'components/connection.php';
session_start();

// Kiểm tra user_id
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

// Lấy ID sản phẩm từ GET
$pid = isset($_GET['pid']) ? $_GET['pid'] : null;

// Xử lý thêm bình luận
if (isset($_POST['add_comment'])) {
    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
    $rating = isset($_POST['rating']) ? $_POST['rating'] : 0;

    if ($pid) {
        // Kiểm tra sản phẩm tồn tại
        $check_product = mysqli_query($conn, "SELECT id FROM products WHERE id = '$pid' LIMIT 1");
        if (mysqli_num_rows($check_product) > 0) {
            // Thêm bình luận
            $insert_comment = mysqli_query($conn, "INSERT INTO comments (product_id, user_id, comment, rating) VALUES ('$pid', '$user_id', '$comment', '$rating')");
            if ($insert_comment) {
                $success_msg[] = 'Bình luận của bạn đã được thêm thành công.';
            } else {
                $warning_msg[] = 'Không thể thêm bình luận.';
            }
        } else {
            $warning_msg[] = 'Sản phẩm không tồn tại.';
        }
    } else {
        $warning_msg[] = 'Không tìm thấy ID sản phẩm.';
    }
}

// Lấy danh sách bình luận
$select_comments = mysqli_query($conn, "SELECT c.comment, c.rating, c.date, u.name FROM comments c JOIN users u ON c.user_id = u.id WHERE c.product_id = '$pid' ORDER BY c.date DESC");

// Truy vấn tổng số sao của các bình luận
$rating_query = mysqli_query($conn, "SELECT AVG(rating) AS average_rating FROM comments WHERE product_id = '$pid'");
$rating_result = mysqli_fetch_assoc($rating_query);
$average_rating = round($rating_result['average_rating'], 1);  //làm tròn 1 số
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Chi tiết sản phẩm</title>
    <style>
        <?php include 'style.css'; ?>.comment-form textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #d4c29e;
            border-radius: 5px;
        }

        .comment-form .rating label {
            font-size: 20px;
            cursor: pointer;
            color: #D4A32A;
        }

        .comment {
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px;
            padding-bottom: 10px;
        }

        .comment strong {
            font-size: 16px;
            color: #8B4513;
        }

        .rating-stars i {
            font-size: 20px;
            color: #D4A32A;
        }
    </style>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>Chi tiết sản phẩm</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/ Chi tiết sản phẩm</span>
        </div>
        <section class="view_page">
            <!-- Hiển thị chi tiết sản phẩm -->
            <?php
            if ($pid) {
                $select_products = mysqli_query($conn, "SELECT * FROM products WHERE id = '$pid'");
                if (mysqli_num_rows($select_products) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_products)) {
            ?>
                        <form method="post">
                            <img src="img/<?php echo $fetch_product['image']; ?>" alt="Product Image">
                            <div class="detail">
                                <!-- Hiển thị đánh giá sao trung bình -->
                                
                                    <p class="average-rating">Đánh giá: <?php echo $average_rating; ?> / 5 sao</p>
                                    <div class="rating-stars">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $average_rating) {
                                                echo "<i class='bx bx-star'></i>";  // Sao đầy
                                            } else {
                                                echo "<i class='bx bx-star-half'></i>";  // Sao rỗng
                                            }
                                        }
                                        ?>
                                    
                                </div>
                                <div class="price">Giá <?php echo $fetch_product['price']; ?> VNĐ / kg</div>
                                <div class="name"><?php echo $fetch_product['name']; ?></div>
                                <div class="product-detail">
                                    <p><?php echo $fetch_product['product_detail']; ?></p>
                                </div>
                                <input type="hidden" name="product_id" value="<?php echo $fetch_product['id']; ?>">
                                <div class="button">
                                    <button type="submit" name="add_to_wishlist" class="btn">Thêm vào danh sách yêu thích <i class="bx bx-heart"></i></button>
                                    <input type="hidden" name="qty" value="1" min="0" class="quantity">
                                    <button type="submit" name="add_to_cart" class="btn">Thêm vào giỏ hàng <i class="bx bx-cart"></i></button>
                                </div>
                            </div>
                        </form>


            <?php
                    }
                } else {
                    echo "<p>Không tìm thấy sản phẩm.</p>";
                }
            } else {
                echo "<p>ID sản phẩm không hợp lệ.</p>";
            }
            ?>

            <!-- Form bình luận -->
            <form method="post" class="comment-form">
                <textarea name="comment" required placeholder="Viết bình luận của bạn..."></textarea>
                <div class="rating">
                    <input type="radio" id="star5" name="rating" value="5">
                    <label for="star5" title="5 sao">&#9733;</label>

                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4" title="4 sao">&#9733;</label>

                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3" title="3 sao">&#9733;</label>

                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2" title="2 sao">&#9733;</label>

                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1" title="1 sao">&#9733;</label>
                </div>

                <button type="submit" name="add_comment" class="btn">Gửi bình luận</button>
            </form>

            <!-- Hiển thị bình luận -->
            <h2>Bình luận</h2>
            <?php
            if (mysqli_num_rows($select_comments) > 0) {
                while ($comment_data = mysqli_fetch_assoc($select_comments)) {
                    echo "<div class='comment'>";
                    echo "<p><strong>" . $comment_data['name'] . "</strong> - " . $comment_data['date'] .  "</p>";
                    // Xuống dòng phần đánh giá sao
                    echo "<div>Đánh giá: " . str_repeat("⭐", $comment_data['rating']) . "</div>";
                    echo "<p>" . $comment_data['comment'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Chưa có bình luận nào cho sản phẩm này.</p>";
            }

            ?>
        </section>

        <?php include 'components/footer.php'; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>

</html>