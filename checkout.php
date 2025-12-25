<?php
include 'components/connection.php';
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('location:login.php');
    exit();
}

// Xử lý đăng xuất
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit();
}

// Tạo mã đơn hàng duy nhất
function generate_order_code()
{
    return uniqid('ORDER_');
}


// Xử lý đặt hàng
if (isset($_POST["place_order"])) {
    $order_code = generate_order_code(); // Tạo mã đơn hàng
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ', ' . $_POST['pincode'], FILTER_SANITIZE_STRING);
    $address_type = filter_var($_POST['address_type'], FILTER_SANITIZE_STRING);
    $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
    $date = date("Y-m-d");

    // Lưu đơn hàng vào bảng `orders`
    $insert_order = mysqli_query($conn, "INSERT INTO orders (order_code, user_id, name, number, email, address, address_type, method, date) 
                                          VALUES ('$order_code', '$user_id', '$name', '$number', '$email', '$address', '$address_type', '$method', '$date')");

    if ($insert_order) {
        // Nếu có `get_id`, xử lý đặt hàng cho sản phẩm riêng lẻ
        if (isset($_GET["get_id"])) {
            $get_id = $_GET["get_id"];
            $get_product = mysqli_query($conn, "SELECT * FROM products WHERE id='$get_id' LIMIT 1");

            if (mysqli_num_rows($get_product) > 0) {
                $fetch_p = mysqli_fetch_assoc($get_product);
                $product_id = $fetch_p['id'];
                $product_name = $fetch_p['name'];
                $price = $fetch_p['price'];

                // Lưu vào bảng `order_details`
                $insert_order_detail = mysqli_query($conn, "INSERT INTO order_details (order_code, user_id, product_id, name, price, qty) 
                                                        VALUES ('$order_code', '$user_id', '$product_id', '$product_name', '$price', 1)");

                // Cập nhật số lượng sản phẩm trong kho và sản phẩm đã bán
                $new_qty = $fetch_p['quantity'] - 1;
                $new_sold = $fetch_p['sold'] + 1; // Cộng vào số sản phẩm đã bán
                $update_product = mysqli_query($conn, "UPDATE products SET quantity='$new_qty', sold='$new_sold' WHERE id='$product_id'");

                if ($insert_order_detail && $update_product) {
                    header('location: order.php');
                    exit();
                }
            }
        } else {
            // Xử lý đặt hàng cho tất cả sản phẩm trong giỏ
            $varify_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'");
            if (mysqli_num_rows($varify_cart) > 0) {
                while ($f_cart = mysqli_fetch_assoc($varify_cart)) {
                    $product_id = $f_cart['product_id'];
                    $price = $f_cart['price'];
                    $qty = $f_cart['qty'];

                    // Lấy thông tin sản phẩm từ bảng `products`
                    $get_product = mysqli_query($conn, "SELECT * FROM products WHERE id='$product_id' LIMIT 1");
                    $fetch_product = mysqli_fetch_assoc($get_product);
                    $product_name = $fetch_product['name'];

                    // Lưu vào bảng `order_details`
                    $insert_order_detail = mysqli_query($conn, "INSERT INTO order_details (order_code, user_id, product_id, name, price, qty) 
                                                            VALUES ('$order_code', '$user_id', '$product_id', '$product_name', '$price', '$qty')");

                    // Cập nhật số lượng sản phẩm trong kho và sản phẩm đã bán
                    $new_qty = $fetch_product['quantity'] - $qty;
                    $new_sold = $fetch_product['sold'] + $qty; // Cộng số lượng đã bán
                    $update_product = mysqli_query($conn, "UPDATE products SET quantity='$new_qty', sold='$new_sold' WHERE id='$product_id'");

                    if (!$update_product) {
                        $warning_msg[] = 'Lỗi cập nhật sản phẩm: ' . $product_name;
                    }
                }

                // Xóa giỏ hàng của người dùng nếu đặt hàng thành công
                $delete_cart = mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");
                header('location: order.php');
                exit();
            }
        }
    } else {
        $warning_msg[] = 'Có lỗi xảy ra.';
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
    <title>ZenCha - Trang thanh toán</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Tóm tắt thanh toán</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/ Tóm tắt thanh toán</span>
        </div>
        <section class="checkout">
            <div class="title">
                <img src="img/logo1.jpg" class="logo">
                <h1>Tóm tắt thanh toán</h1>
                <p>Nhanh-Tiện ích-Hiện đại</p>
            </div>
            <div class="row">
                <form method="post">
                    <h3>Chi tiết thanh toán</h3>
                    <div class="flex">
                        <div class="box">
                            <div class="input-field">
                                <p>Họ và tên *</p>
                                <input type="text" name="name" required maxlength="50" placeholder=" Vui lòng nhập tên của bạn" class="input">
                            </div>
                            <div class="input-field">
                                <p>Số điện thoại *</p>
                                <input type="number" name="number" required maxlength="10" placeholder="Vui lòng nhập số điện thoại của bạn" class="input">
                            </div>
                            <div class="input-field">
                                <p>Địa chỉ email *</p>
                                <input type="email" name="email" required maxlength="50" placeholder="Vui lòng nhập địa chỉ email của bạn" class="input">
                            </div>
                            <div class="input-field">
                                <p>Phương thức thanh toán *</p>
                                <select name="method" class="input">
                                    <option value="Thanh toán khi nhận hàng">Thanh toán khi nhận hàng</option>
                                    <option value="Thẻ tín dụng hoặc thẻ ghi nợ">Thẻ tín dụng hoặc thẻ ghi nợ</option>
                                    <option value="Ngân hàng ròng">Ngân hàng ròng</option>
                                    <option value="UPI hoặc RuPay">UPI hoặc RuPay</option>
                                    <option value="paytm">Paytm</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <p>Loại địa chỉ *</p>
                                <select name="address_type" class="input">
                                    <option value="home">Nhà</option>
                                    <option value="office">Văn Phòng</option>
                                </select>
                            </div>
                        </div>
                        <div class="box">
                            <div class="input-field">
                                <p>Phường / Xã *</p>
                                <input type="text" name="flat" required maxlength="50" placeholder="e.g. Số căn hộ & tòa nhà" class="input">
                            </div>
                            <div class="input-field">
                                <p>Quận / Huyện *</p>
                                <input type="text" name="street" required maxlength="50" placeholder="e.g. Tên Quận & Huyện" class="input">
                            </div>
                            <div class="input-field">
                                <p>Tỉnh / Thành Phố *</p>
                                <input type="text" name="city" required maxlength="50" placeholder="Nhập Tỉnh & Thành phố" class="input">
                            </div>
                            <div class="input-field">
                                <p>Tên Nước</p>
                                <input type="text" name="country" required maxlength="50" placeholder="Việt Nam" class="input">
                            </div>
                            <div class="input-field">
                                <p>Pincode</p>
                                <input type="text" name="pincode" required maxlength="6" placeholder="110022" min="0" max="999999" class="input">
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="place_order" class="btn">Đặt hàng</button>
                </form>
                <div class="summary">
                    <h3>My Bag</h3>
                    <div class="box-container">
                        <?php
                        $grand_total = 0;
                        if (isset($_GET['get_id'])) {
                            $select_get = mysqli_query($conn, "SELECT * FROM products WHERE id = '" . $_GET['get_id'] . "'");
                            if ($row = mysqli_fetch_assoc($select_get)) {
                                $sub_total = $row['price'];
                                $grand_total += $sub_total;
                        ?>
                                <div class="flex">
                                    <img src="img/<?= $row['image']; ?>" class="image">
                                    <div>
                                        <h3 class="name"><?= $row['name']; ?></h3>
                                        <p class="price">Giá <?= $row['price']; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");
                            if (mysqli_num_rows($select_cart) > 0) {
                                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                                    $product_id = $fetch_cart["product_id"];
                                    $select_products = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");
                                    $fetch_product = mysqli_fetch_assoc($select_products);
                                    $sub_total = $fetch_product["price"] * $fetch_cart["qty"];
                                    $grand_total += $sub_total;
                                ?>
                                    <div class="flex">
                                        <img src="img/<?= $fetch_product['image']; ?>" class="image">
                                        <div>
                                            <h3 class="name"><?= $fetch_product["name"]; ?></h3>
                                            <p class="price">Giá <?= $fetch_product["price"]; ?> x <?= $fetch_cart["qty"]; ?></p>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>
                    <div class="total">Tổng tiền sản phẩm <span><?= $grand_total; ?> VNĐ</span></div>
                </div>
            </div>
        </section>
    </div>
    <?php include 'components/footer.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
</body>

</html>