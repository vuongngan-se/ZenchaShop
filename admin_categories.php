<?php
include 'components/connection.php';
session_start();

// Kiểm tra quyền truy cập admin
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
    exit();
}

// Lấy danh sách danh mục
$categories = mysqli_query($conn, "SELECT * FROM danhmuc") or die('Query failed');

// Xử lý cập nhật danh mục
if (isset($_POST['update_category'])) {
    $update_id = $_POST['category_id'];
    $update_name = mysqli_real_escape_string($conn, $_POST['name']);

    $query = "UPDATE danhmuc SET name = '$update_name' WHERE id = '$update_id'";
    mysqli_query($conn, $query) or die('Query failed');
    $success_msg = "Category updated successfully!";
}
// Xử lý thêm danh mục
if (isset($_POST['add_category'])) {
    $new_category_name = mysqli_real_escape_string($conn, $_POST['new_category_name']);

    if (!empty($new_category_name)) {
        $query = "INSERT INTO danhmuc (name) VALUES ('$new_category_name')";
        mysqli_query($conn, $query) or die('Query failed');
        $success_msg = "Thêm danh mục thành công!";
    } else {
        $error_msg = "Tên danh mục không được để trống!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý danh mục</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style type="text/css">
        <?php include 'style2.css'; ?>.btn {
            background-color: #8B4513;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #A0522D;
        }
    </style>
</head>

<body>
    <?php include 'components/admin_header.php'; ?>

    <section class="category-management">
        <h1>Quản lý danh mục</h1>

        <?php if (isset($success_msg)) { ?>
            <p class="success"><?php echo $success_msg; ?></p>
        <?php } ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($categories) > 0) {
                    while ($category = mysqli_fetch_assoc($categories)) {
                ?>
                        <tr>
                            <form method="post" action="">
                                <td><?php echo $category['id']; ?></td>
                                <td>
                                    <input type="text" name="name" value="<?php echo $category['name']; ?>" required>
                                </td>
                                <td>
                                    <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                                    <input type="submit" name="update_category" value="Update" class="btn">
                                </td>
                            </form>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='3'>Không có danh mục nào</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <section class="add-category">
        <h2>Thêm danh mục</h2>

        <?php if (isset($success_msg)) { ?>
            <p class="success"><?php echo $success_msg; ?></p>
        <?php } ?>

        <?php if (isset($error_msg)) { ?>
            <p class="error"><?php echo $error_msg; ?></p>
        <?php } ?>

        <form method="post" action="">
            <label for="new_category_name">Thêm danh mục:</label>
            <input type="text" id="new_category_name" name="new_category_name" placeholder="Nhập tên danh mục" required>
            <input type="submit" name="add_category" value="Thêm danh mục" class="btn">
        </form>
    </section>

</body>

</html>