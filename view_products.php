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

    // Thêm sản phẩm vào wishlist
    if (isset($_POST['add_to_wishlist'])) {
        $product_id = $_POST['product_id'];
        if (addToWishlist($user_id, $product_id)) {
            $_SESSION['added_to_wishlist'] = true;
        } else {
            $_SESSION['wishlist_exists'] = true;
        }
    }

    // Thêm sản phẩm vào giỏ hàng
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        $qty =$_POST['qty'];

        if (addToCart($user_id, $product_id, $qty)) {
            $_SESSION['added_to_cart'] = true;
        } else {
            $_SESSION['cart_exists'] = true; // Sản phẩm đã có trong giỏ hàng
        }
    }

    // Hàm thêm vào wishlist
    function addToWishlist($user_id, $product_id)
    {
        global $conn;

        // Kiểm tra sản phẩm đã có trong wishlist chưa
        $varify_wishlist = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id = '$user_id' AND product_id = '$product_id'");
        if (mysqli_num_rows($varify_wishlist) > 0) {
            return false;
        }

        // Lấy giá sản phẩm từ bảng `product`
        $select_price = mysqli_query($conn, "SELECT price FROM products WHERE id = '$product_id' LIMIT 1");

        if (mysqli_num_rows($select_price) > 0) {
            $fetch_price = mysqli_fetch_assoc($select_price);
            $price = $fetch_price['price'];

            // Thêm vào bảng wishlist
            $insert_wishlist = mysqli_query($conn, "INSERT INTO wishlist (user_id, product_id, price) VALUES ('$user_id', '$product_id', '$price')");
            return true;
        }
        return false;
    }

    // Hàm thêm vào giỏ hàng
    function addToCart($user_id, $product_id, $qty)
    {
        global $conn;
        $qty = 1;

        // Kiểm tra số lượng sản phẩm trong kho
        $check_quantity = mysqli_query($conn, "SELECT quantity FROM products WHERE id = '$product_id'");
        if (mysqli_num_rows($check_quantity) > 0) {
            $fetch_quantity = mysqli_fetch_assoc($check_quantity);
            $available_qty = $fetch_quantity['quantity'];

            if ($available_qty <= 0) {
                $_SESSION['out_of_stock'] = true; // Lưu thông báo hết hàng vào session
                return false;
            }
        } else {
            return false; // Nếu không tìm thấy sản phẩm, trả về false
        }

        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $varify_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'");
        if (mysqli_num_rows($varify_cart) > 0) {
            return false;
        }

        $select_price = mysqli_query($conn, "SELECT price FROM products WHERE id = '$product_id' LIMIT 1");
        if (mysqli_num_rows($select_price) > 0) {
            $fetch_price = mysqli_fetch_assoc($select_price);
            $price = $fetch_price['price'];

            $insert_cart = mysqli_query($conn, "INSERT INTO cart (user_id, product_id, price, qty) VALUES ('$user_id', '$product_id', '$price', '$qty')");
            return true;
        }
        return false;
    }

    // Lấy giá trị tìm kiếm và danh mục từ form
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $category = isset($_GET['category']) ? intval($_GET['category']) : 0;

    // Xử lý phân trang
    $limit = 6; // Số sản phẩm trên mỗi trang
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $start_from = ($page - 1) * $limit;

    //  tìm kiếm
    $query = "SELECT * FROM products WHERE 1";

    if ($search) {
        $query .= " AND name LIKE '%$search%'";
    }
    if ($category) {
        $query .= " AND iddm = '$category'";
    }

    $total_query = $query;
    $query .= " LIMIT $start_from, $limit";


    $select_products = mysqli_query($conn, $query);
    $total_records = mysqli_query($conn, str_replace("SELECT *", "SELECT COUNT(*)", $total_query));
    $total_records = mysqli_fetch_array($total_records)[0];
    $total_pages = ceil($total_records / $limit);

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
        <title>ZenCha - Sản phẩm</title>
    </head>

    <body>
        <?php include 'components/header.php'; ?>
        <div class="main">
            <div class="banner">
                <h1>Cửa Hàng</h1>
            </div>
            <div class="title2">
                <a href="home.php">Home</a><span>/ Cửa Hàng</span>
            </div>

            <!-- Tìm kiếm sản phẩm -->
            <form id="search-form" action="" method="get" class="search-form">
                <input type="text" name="search" id="search" placeholder="Tìm kiếm sản phẩm..." value="<?= $search ?>">
                <button type="submit"><i class="bx bx-search"></i></button>
            </form>
            <!-- Lấy danh mục từ cơ sở dữ liệu -->
            <?php
            $categories = mysqli_query($conn, "SELECT * FROM danhmuc");
            ?>

            <form id="category-form" action="" method="get" class="search-form">

                <select name="category" id="category">
                    <option value="">Tất cả danh mục</option>
                    <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
                        <option value="<?= $category['id']; ?>" <?= isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'selected' : '' ?>>
                            <?= $category['name']; ?>
                        </option>
                    <?php } ?>
                </select>
                <button type="submit"><i class="bx bx-search"></i></button>
            </form>


            <section class="products" id="product-container">
                <div class="box-container">
                    <?php
                    if (mysqli_num_rows($select_products) > 0) {
                        while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                    ?>
                            <form action="" method="post" class="box">
                                <img src="img/<?= $fetch_products['image']; ?>" class="img">
                                <div class="button">
                                    <?php if ($fetch_products['quantity'] > 0) { ?>
                                        <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                                        <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                                    <?php } else { ?>
                                        <button type="button" disabled style="cursor: not-allowed; opacity: 0.6;">Hết hàng</button>
                                    <?php } ?>
                                    <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="bx bxs-show"></a>
                                </div>
                                <h3 class="name"><?= $fetch_products['name']; ?></h3>
                                <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                                <div class="flex">
                                    <p class="price">Giá <?= $fetch_products['price']; ?> VNĐ / kg</p>
                                    <p class="quantity">Số lượng còn: <?= $fetch_products['quantity']; ?></p>
                                    <p class="sold">Đã bán: <?= $fetch_products['sold']; ?></p>
                                </div>
                                <?php if ($fetch_products['quantity'] > 0) { ?>
                                    <a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn">Mua Ngay</a>
                                <?php } else { ?>
                                    <a href="#" class="btn" style="cursor: not-allowed; opacity: 0.6;">Hết hàng</a>
                                <?php } ?>
                            </form>

                    <?php
                        }
                    } else {
                        echo '<p class="empty">Chưa có sản phẩm nào được thêm vào!</p>';
                    }
                    ?>
                </div>
            </section>


            <!-- Phân trang -->
            <div class="pagination" id="pagination">
                <ul>
                    <?php
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<li><a href='?page=$i&search=$search'>$i</a></li>";
                    }
                    ?>
                </ul>
            </div>

            <?php include 'components/footer.php'; ?>
            <?php include 'ai_chatbox.php'; ?>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script src="script.js"></script>


        <?php
        if (isset($_SESSION['added_to_cart']) && $_SESSION['added_to_cart'] === true) {
            echo "<script>
                swal('Sản phẩm đã được thêm vào giỏ hàng!', '', 'success');
            </script>";
            unset($_SESSION['added_to_cart']);
        }

        if (isset($_SESSION['added_to_wishlist']) && $_SESSION['added_to_wishlist'] === true) {
            echo "<script>
                swal('Sản phẩm đã được thêm vào danh sách yêu thích!', '', 'success');
            </script>";
            unset($_SESSION['added_to_wishlist']);
        }

        if (isset($_SESSION['cart_exists']) && $_SESSION['cart_exists'] === true) {
            echo "<script>
                swal('Sản phẩm đã có trong giỏ hàng!', '', 'warning');
            </script>";
            unset($_SESSION['cart_exists']);
        }

        if (isset($_SESSION['wishlist_exists']) && $_SESSION['wishlist_exists'] === true) {
            echo "<script>
                swal('Sản phẩm đã có trong danh sách yêu thích!', '', 'warning');
            </script>";
            unset($_SESSION['wishlist_exists']);
        }
        ?>

        <?php include 'components/alert.php'; ?>
        <?php
        if (isset($_SESSION['out_of_stock']) && $_SESSION['out_of_stock'] === true) {
            echo "<script>
        swal('Sản phẩm đã hết hàng!', '', 'warning');
    </script>";
            unset($_SESSION['out_of_stock']);
        }
        ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Load sản phẩm đầu tiên
                function loadProducts(page = 1) {
                    const search = $('#search').val(); //lấy dữ liệu ô tìm kiếm
                    const category = $('#category').val();

                    $.ajax({
                        url: 'pagination_ajax.php',
                        method: 'GET',
                        data: {
                            page,
                            search,
                            category
                        },
                        dataType: 'json', //trả đữ liệu định dạng JSon
                        success: function(response) {
                            // Cập nhật sản phẩm
                            $('#product-container .box-container').html(response.products);

                            // Cập nhật phân trang
                            $('#pagination ul').html(response.pagination);
                        },
                        error: function() {
                            alert('Lỗi khi tải sản phẩm.');
                        }
                    });
                }

                // Xử lý tìm kiếm và danh mục
                $('#search-form, #category-form').on('submit', function(e) {
                    e.preventDefault();
                    loadProducts(1);
                });

                // Xử lý nhấp phân trang
                $(document).on('click', '.pagination-link', function() {
                    const page = $(this).data('page');
                    loadProducts(page);
                });

                // Load sản phẩm mặc định
                loadProducts();
            });
        </script>
    </body>

    </html>