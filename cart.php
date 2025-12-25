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
// Cập nhật sản phẩm trong giỏ hàng
if (isset($_POST["update_cart"])) {
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);

    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $select_cart_item = mysqli_query($conn, "SELECT * FROM cart WHERE id = '$cart_id'");
    $fetch_cart_item = mysqli_fetch_assoc($select_cart_item);
    $product_id = $fetch_cart_item['product_id'];

    // Lấy thông tin kho của sản phẩm
    $select_product = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");
    $fetch_product = mysqli_fetch_assoc($select_product);
    $product_stock = $fetch_product['quantity']; // Số lượng trong kho

    // Kiểm tra nếu số lượng sản phẩm trong giỏ lớn hơn số lượng trong kho
    if ($qty > $product_stock) {
        $warning_msg[] = "Số lượng sản phẩm trong kho không đủ. Vui lòng nhập lại.";
    } else {
        // Nếu đủ kho, thực hiện cập nhật số lượng sản phẩm
        $update_qty = mysqli_query($conn, "UPDATE cart SET qty = '$qty' WHERE id = '$cart_id'");

        if ($update_qty) {
            $success_msg[] = "Số lượng giỏ hàng được cập nhật thành công";
        } else {
            $warning_msg[] = "Không thể cập nhật số lượng giỏ hàng";
        }
    }
}




if (isset($_POST['delete_item'])) {
    // Lấy giá trị `cart_id` từ biểu mẫu
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
    // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng của người dùng hay không
    $verify_delete_item = mysqli_query($conn, "SELECT * FROM cart WHERE id = '$cart_id' AND user_id = '$user_id'");

    if (mysqli_num_rows($verify_delete_item) > 0) {
        // Xóa sản phẩm ra khỏi giỏ hàng (CHỈ XÓA MỤC CÓ ID KHỚP)
        $delete_cart_item = mysqli_query($conn, "DELETE FROM cart WHERE id = '$cart_id' AND user_id = '$user_id'");

        if ($delete_cart_item) {
            $success_msg[] = "Mục giỏ hàng đã được xóa thành công";
        } else {
            $warning_msg[] = "Không thể xóa mục giỏ hàng. Vui lòng thử lại.";
        }
    } else {
        $warning_msg[] = "Mặt hàng không tồn tại trong giỏ hàng của bạn.";
    }
}

// Kiểm tra nếu người dùng nhấn nút "empty cart"
if (isset($_POST["empty_cart"])) {
    // Kiểm tra xem giỏ hàng của người dùng có sản phẩm nào không
    $varify_empty_items = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");

    if (mysqli_num_rows($varify_empty_items) > 0) {
        // Xóa toàn bộ sản phẩm trong giỏ hàng của người dùng
        $delete_cart_items = mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");
        if ($delete_cart_items) {
            $success_msg[] = "Giỏ hàng đã được làm trống thành công";
        } else {
            $warning_msg[] = "Không thể làm trống giỏ hàng";
        }
    } else {
        $warning_msg[] = "Giỏ hàng đã trống";
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
    <title>ZenCha - Trang giỏ hàng</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Giỏ hàng của tôi</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/ Giỏ hàng</span>
        </div>
        <section class="products">
            <h1 class="title">Sản phẩm được thêm vào giỏ hàng</h1>
            <div class="box-container">
                <?php
                $grand_total = 0;
                $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");
                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $product_id = $fetch_cart['product_id'];
                        $select_products = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");
                        if (mysqli_num_rows($select_products) > 0) {
                            $fetch_product = mysqli_fetch_assoc($select_products);
                ?>
                            <form method="post" action="" class="box">
                                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                                <img src="img/<?= $fetch_product['image']; ?>" class="img">
                                <h3 class="name"><?= $fetch_product['name']; ?></h3>
                                <div class="flex">
                                    <p class="price">Giá: <?= $fetch_product['price']; ?> VNĐ / kg</p>
                                    <input type="number" name="qty" required min="1" value="<?= $fetch_cart['qty']; ?>" max="99" maxlength="2" class="qty">
                                    <button type="submit" name="update_cart" class="bx bxs-edit fa-edit"></button>

                                </div>
                                <p class="sub-total">
                                    Tổng : <span>$<?= $sub_total = (floatval($fetch_cart['qty']) * floatval($fetch_cart['price'])) ?></span>
                                </p>

                                <button type="submit" name="delete_item" class="btn" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</button>



                            </form>
                <?php
                            $grand_total += $sub_total;
                        } else {
                            echo '<p class="empty"> sản phẩm không được tìm thấy</p>';
                        }
                    }
                } else {
                    echo '<p class="empty">Chưa có sản phẩm nào được thêm vào!</p>';
                }
                ?>
            </div>
            <?php
            if ($grand_total != 0) {

            ?>
                <div class="cart-total">
                    <p>TỔNG SỐ TIỀN HÀNG: <span>$ <?= $grand_total; ?></span></p>
                    <div class="button">
                        <form method="post">
                            <button type="submit" name="empty_cart" class="btn" onclick="return confirm('bạn có chắc chắn để trống giỏ hàng của bạn không')">Giỏ hàng trống</button>

                        </form>
                        <a href="checkout.php" class="btn">tiến hành thanh toán</a>

                    </div>
                </div>
            <?php } ?>
        </section>
        <?php include 'components/footer.php'; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>

</html>