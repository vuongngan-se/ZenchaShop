<?php
include 'components/connection.php';
session_start();

// Kiểm tra quyền truy cập admin
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
    exit();
}

// Kiểm tra xem ID sản phẩm có được truyền vào không
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $query = "SELECT products.*, danhmuc.id AS category_id 
              FROM products 
              LEFT JOIN danhmuc ON products.iddm = danhmuc.id 
              WHERE products.id = '$product_id'";
    $result = mysqli_query($conn, $query) or die('Query failed');
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        header("location: admin_dashboard.php");
        exit();
    }
} else {
    header("location: admin_dashboard.php");
    exit();
}

// Cập nhật thông tin sản phẩm
if (isset($_POST['update_product'])) {
    $update_id = $_POST['product_id'];
    $update_name = mysqli_real_escape_string($conn, $_POST['name']);
    $update_price = mysqli_real_escape_string($conn, $_POST['price']);
    $update_detail = mysqli_real_escape_string($conn, $_POST['detail']);
    $update_quantity = intval($_POST['quantity']);
    $update_category = intval($_POST['iddm']);

    if (!empty($_FILES['image']['name'])) {
        $update_image = $_FILES['image']['name'];
        $update_image_tmp_name = $_FILES['image']['tmp_name'];
        $update_image_folder = 'img/' . $update_image;

        // Di chuyển hình ảnh mới vào thư mục img
        if (move_uploaded_file($update_image_tmp_name, $update_image_folder)) {
            $query = "UPDATE products SET 
                        name = '$update_name', 
                        price = '$update_price', 
                        product_detail = '$update_detail', 
                        quantity = '$update_quantity', 
                        iddm = '$update_category', 
                        image = '$update_image' 
                      WHERE id = '$update_id'";
        }
    } else {
        $query = "UPDATE products SET 
                    name = '$update_name', 
                    price = '$update_price', 
                    product_detail = '$update_detail', 
                    quantity = '$update_quantity', 
                    iddm = '$update_category' 
                  WHERE id = '$update_id'";
    }

    mysqli_query($conn, $query) or die('Query failed');
    header("location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style type="text/css">
        <?php include 'style2.css'; ?>
    </style>
</head>

<body>
    <?php include 'components/admin_header.php'; ?>

    <section class="product-management">
        <h1>Edit Product</h1>

        <!-- Form chỉnh sửa sản phẩm -->
        <form action="" method="post" enctype="multipart/form-data" class="form-container">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <h2>Edit Product Information</h2>
            <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
            <input type="number" name="price" value="<?php echo $product['price']; ?>" required>
            <textarea name="detail" required><?php echo $product['product_detail']; ?></textarea>
            <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" min="0" required> <!-- Sửa số lượng -->
            
            <!-- Lựa chọn danh mục -->
            <select name="iddm" required>
                <option value="">Select Category</option>
                <?php
                $categories = mysqli_query($conn, "SELECT * FROM danhmuc") or die('Query failed');
                while ($category = mysqli_fetch_assoc($categories)) {
                    $selected = ($product['category_id'] == $category['id']) ? 'selected' : '';
                    echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                }
                ?>
            </select>

            <!-- Cập nhật hình ảnh -->
            <input type="file" name="image">
            <p>Current Image:</p>
            <img src="img/<?php echo $product['image']; ?>" width="100">
            
            <input type="submit" name="update_product" value="Update Product" class="btn">
        </form>
    </section>
</body>

</html>
