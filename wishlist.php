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

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $qty = 1;
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);

    $varify_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'");
    $max_cart_items = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");

    if (mysqli_num_rows($varify_cart) > 0) {
        $warning_msg[] = 'Sản phẩm đã tồn tại trong giỏ hàng của bạn';
    } elseif (mysqli_num_rows($max_cart_items) >= 20) {
        $warning_msg[] = 'Giỏ hàng đã đầy';
    } else {
        $select_price = mysqli_query($conn, "SELECT price FROM products WHERE id = '$product_id' LIMIT 1");

        if (mysqli_num_rows($select_price) > 0) {
            $fetch_price = mysqli_fetch_assoc($select_price);
            $price = $fetch_price['price'];

            $insert_cart = mysqli_query($conn, "INSERT INTO cart (user_id, product_id, price, qty) VALUES ('$user_id', '$product_id', '$price', '$qty')");

            if ($insert_cart) {
                $success_msg[] = 'Sản phẩm được thêm vào giỏ hàng thành công';
            } else {
                $warning_msg[] = 'Không thêm được sản phẩm vào giỏ hàng';
            }
        } else {
            $warning_msg[] = 'Không tìm thấy sản phẩm';
        }
    }
}

if (isset($_POST['delete_item'])) {
    $wishlist_id = $_POST['wishlist_id'];
    $wishlist_id = filter_var($wishlist_id, FILTER_SANITIZE_STRING);

    $varify_delete_items = mysqli_query($conn, "SELECT * FROM wishlist WHERE id = '$wishlist_id'");

    if (mysqli_num_rows($varify_delete_items) > 0) {
        $delete_wishlist_id = mysqli_query($conn, "DELETE FROM wishlist WHERE id = '$wishlist_id'");
        $success_msg[] = "Mục danh sách yêu thích đã được xóa thành công";
    } else {
        $warning_msg[] = "Mục danh sách yêu thích đã bị xóa";
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>ZenCha - Trang danh sách yêu thích</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Danh sách yêu thích của tôi</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/ Danh sách yêu thích</span>
        </div>
        <section class="products">
            <h1 class="title">Sản phẩm được thêm vào danh sách yêu thích</h1>
            <div class="box-container">
                <?php
                $grand_total = 0;
                $select_wishlist = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id = '$user_id'");
                if (mysqli_num_rows($select_wishlist) > 0) {
                    while ($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)) {
                        $product_id = $fetch_wishlist['product_id'];
                        $select_products = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");
                        if (mysqli_num_rows($select_products) > 0) {
                            $fetch_product = mysqli_fetch_assoc($select_products);
                            ?>
                            <form method="post" action="" class="box">
                                <input type="hidden" name="wishlist_id" value="<?=$fetch_wishlist['id']; ?>">
                                <img src="img/<?=$fetch_product['image']; ?>" alt="<?=$fetch_product['name']; ?>">
                                <div class="button">
                                    <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                                    <a href="view_page.php?pid=<?= $fetch_product['id']; ?>" class="bx bxs-show"></a>
                                    <button type="submit" name="delete_item" onclick="return confirm('Delete this item?')"><i class="bx bx-x"></i></button>
                                </div>
                                <h3 class="name"><?=$fetch_product['name']; ?></h3>
                                <input type="hidden" name="product_id" value="<?=$fetch_product['id']; ?>">
                                <div class="flex">
                                    <p class="price">Giá: <?=$fetch_product['price']; ?> VNĐ / kg</p>
                                </div>
                                <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn">Mua ngay</a>
                            </form>
                            <?php
                            $grand_total += $fetch_wishlist['price'];
                        }
                    }
                } else {
                    echo '<p class="empty">Chưa có sản phẩm nào được thêm vào!</p>';
                }
                ?>
            </div>
        </section>
        <?php include 'components/footer.php'; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>

</html>
