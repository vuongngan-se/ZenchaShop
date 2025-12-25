<?php
include 'components/connection.php';
session_start();

// Kiểm tra quyền truy cập admin
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
    exit();
}

// Thêm sản phẩm
if (isset($_POST['add_product'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['price']);
    $product_detail = mysqli_real_escape_string($conn, $_POST['detail']);
    $product_quantity = intval($_POST['quantity']);
    $iddm = intval($_POST['iddm']);
    $product_image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'img/' . $product_image;

    if (move_uploaded_file($image_tmp_name, $image_folder)) {
        $query = "INSERT INTO products (name, price, product_detail, quantity, iddm, image) 
                  VALUES ('$product_name', '$product_price', '$product_detail', '$product_quantity', '$iddm', '$product_image')";
        mysqli_query($conn, $query) or die('query failed');
        $success_msg = "Sản phẩm đã được thêm thành công";
    } else {
        $error_msg = "Không thể tải ảnh";
    }
}

// Xóa sản phẩm
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $query = "DELETE FROM products WHERE id = '$delete_id'";
    mysqli_query($conn, $query) or die('query failed');
    header("location: admin_dashboard.php");
    exit();
}

// Sửa sản phẩm
if (isset($_POST['update_product'])) {
    $update_id = $_POST['product_id'];
    $update_name = mysqli_real_escape_string($conn, $_POST['name']);
    $update_price = mysqli_real_escape_string($conn, $_POST['price']);
    $update_detail = mysqli_real_escape_string($conn, $_POST['detail']);
    $iddm = intval($_POST['iddm']);

    if (!empty($_FILES['image']['name'])) {
        $update_image = $_FILES['image']['name'];
        $update_image_tmp_name = $_FILES['image']['tmp_name'];
        $update_image_folder = 'img/' . $update_image;
        move_uploaded_file($update_image_tmp_name, $update_image_folder);
        $query = "UPDATE products SET name = '$update_name', price = '$update_price', product_detail = '$update_detail', image = '$update_image', iddm = '$iddm' WHERE id = '$update_id'";
    } else {
        $query = "UPDATE products SET name = '$update_name', price = '$update_price', product_detail = '$update_detail', iddm = '$iddm' WHERE id = '$update_id'";
    }
    mysqli_query($conn, $query) or die('query failed');
    header("location: admin_dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Products</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style type="text/css">
        <?php include 'style2.css'; ?>
    </style>
</head>

<body>
    <?php include 'components/admin_header.php'; ?>
    <section class="product-management">
        <h1>Manage Products</h1>

        <?php if (isset($success_msg)) echo "<p class='success'>$success_msg</p>"; ?>
        <?php if (isset($error_msg)) echo "<p class='error'>$error_msg</p>"; ?>

        <!-- Form Thêm Sản Phẩm -->
        <form action="" method="post" enctype="multipart/form-data" class="form-container">
            <h2>Add Product</h2>
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="number" name="price" placeholder="Product Price" required>
            <h4>Product Detail</h4>
            <textarea name="detail" placeholder="Product Detail" required></textarea>



            <input type="number" name="quantity" placeholder="Product Quantity" min="0" required>
            <select name="iddm" required>
                <option value="">Select Category</option>
                <?php
                $categories = mysqli_query($conn, "SELECT * FROM danhmuc") or die('query failed');
                while ($category = mysqli_fetch_assoc($categories)) {
                    echo "<option value='{$category['id']}'>{$category['name']}</option>";
                }
                ?>
            </select>
            <input type="file" name="image" required>
            <input type="submit" name="add_product" value="Add Product" class="btn">
        </form>

        <!-- Form Lọc Theo Danh Mục -->
        <form method="GET" action="" class="filter-form">
            <label for="category_filter">Filter by Category:</label>
            <select name="category" id="category_filter" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php
                $categories = mysqli_query($conn, "SELECT * FROM danhmuc") or die('query failed');
                while ($category = mysqli_fetch_assoc($categories)) {
                    $selected = (isset($_GET['category']) && $_GET['category'] == $category['id']) ? 'selected' : '';
                    echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                }
                ?>
            </select>
        </form>

        <!-- Danh sách sản phẩm -->
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Sold</th>
                    <th>Detail</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $filter_category = isset($_GET['category']) ? intval($_GET['category']) : '';

                $query = "SELECT products.*, danhmuc.name AS category_name 
                          FROM products 
                          LEFT JOIN danhmuc ON products.iddm = danhmuc.id";
                if ($filter_category) {
                    $query .= " WHERE products.iddm = $filter_category";
                }
                $select_products = mysqli_query($conn, $query) or die('query failed');

                if (mysqli_num_rows($select_products) > 0) {
                    while ($product = mysqli_fetch_assoc($select_products)) {
                        echo "<tr>
                                <td><img src='img/{$product['image']}' width='100'></td>
                                <td>{$product['name']}</td>
                                <td>\${$product['price']}</td>
                                <td>{$product['quantity']}</td>
                                <td>{$product['category_name']}</td>
                                <td>{$product['sold']}</td>
                                <td>{$product['product_detail']}</td>
                                
                                <td>
                                    <a href='admin_dashboard.php?delete={$product['id']}' class='btn delete'>Delete</a>
                                    <a href='admin_edit_product.php?id={$product['id']}' class='btn edit'>Edit</a>
                                    <a href='view_comment.php?idcmt={$product['id']}' class='btn comment'>View Comments</a>
                            </td>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Không có sản phẩm</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>

<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('detail');
</script>


</html>