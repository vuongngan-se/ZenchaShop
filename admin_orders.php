<?php
include 'components/connection.php';
session_start();

// Kiểm tra quyền truy cập admin
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
    exit();
}

// Xử lý cập nhật trạng thái đơn hàng
if (isset($_POST['update_status'])) {
    $order_code = $_POST['order_code'];
    $status = $_POST['status'];

    $update_status_query = mysqli_query($conn, "UPDATE orders SET status='$status' WHERE order_code='$order_code'");

    if ($update_status_query) {
        echo "<script>alert('Cập nhật trạng thái thành công!');</script>";
    } else {
        echo "<script>alert('Cập nhật trạng thái thất bại.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <style type="text/css">
        <?php include 'style2.css'; ?>.btn {
            background-color: #8B4513;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #A0522D;
        }
    </style>
</head>

<body>

    <?php include 'components/admin_header.php'; ?>

    <section class="order-management">
        <h1>Quản lý đơn hàng</h1>
        <table>
            <thead>
                <tr>
                    <th>Order Code</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_orders = mysqli_query($conn, "SELECT * FROM orders") or die('Query failed');
                if (mysqli_num_rows($select_orders) > 0) {
                    while ($order = mysqli_fetch_assoc($select_orders)) {
                        echo "<tr>
                            <td>{$order['order_code']}</td>
                            <td>{$order['user_id']}</td>
                            <td>{$order['name']}</td>
                            <td>{$order['email']}</td>
                            <td>{$order['address']}</td>
                            <td>{$order['date']}</td>
                            <td>{$order['status']}</td>
                            <td>
                            <a href='admin_order_detail.php?order_code={$order['order_code']}' class='btn'>View Details</a>

                                <form method='post' style='display:inline;'>
                                    <input type='hidden' name='order_code' value='{$order['order_code']}'>
                                    <select name='status'>
                                        <option value='pending' " . ($order['status'] == 'pending' ? 'selected' : '') . ">Đang xác nhận</option>
                                        <option value='confirmed' " . ($order['status'] == 'confirmed' ? 'selected' : '') . ">Đã xác nhận</option>
                                        <option value='canceled' " . ($order['status'] == 'canceled' ? 'selected' : '') . ">Đã hủy</option>
                                    </select>
                                    <button type='submit' name='update_status' class='btn'>Update Status</button>
                                </form>
                            </td>
                            
                          </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No orders available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

</body>

</html>