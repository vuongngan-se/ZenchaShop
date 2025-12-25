<?php
include 'components/connection.php';
session_start();

// Kiểm tra quyền truy cập admin
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
    exit();
}

// Xóa người dùng
if (isset($_GET['delete_user'])) {
    $delete_id = $_GET['delete_user'];
    $query = "DELETE FROM users WHERE id = '$delete_id'";
    mysqli_query($conn, $query) or die('Query failed');
    header("location: admin_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Users</title>
    <style type="text/css">
        <?php include 'style2.css'; ?>
    </style>
</head>

<body>

    <?php include 'components/admin_header.php'; ?>

    <section class="user-management">
        <h1>Manage Users</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_users = mysqli_query($conn, "SELECT * FROM users") or die('Query failed');
                if (mysqli_num_rows($select_users) > 0) {
                    while ($user = mysqli_fetch_assoc($select_users)) {
                        echo "<tr>
                            <td>{$user['id']}</td>
                            <td>{$user['name']}</td>
                            <td>{$user['email']}</td>
                            <td>
                                <a href='admin_users.php?delete_user={$user['id']}' class='btn delete'>Delete</a>
                            </td>
                          </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

</body>

</html>