<?php
// Bao gồm thư viện SweetAlert
echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

// Hàm hiển thị thông báo bằng SweetAlert
function showAlert($type, $msg) {
    echo "<script> swal('$msg', '', '$type'); </script>";
}

// Hiển thị thông báo thành công (success)
if (isset($success_msg) && is_array($success_msg)) {
    foreach ($success_msg as $msg) {
        showAlert("success", $msg);
    }
}

// Hiển thị thông báo cảnh báo (warning)
if (isset($warning_msg) && is_array($warning_msg)) {
    foreach ($warning_msg as $msg) {
        showAlert("warning", $msg);
    }
}

// Hiển thị thông báo thông tin (info)
if (isset($info_msg) && is_array($info_msg)) {
    foreach ($info_msg as $msg) {
        showAlert("info", $msg);
    }
}

// Hiển thị thông báo lỗi (error)
if (isset($error_msg) && is_array($error_msg)) {
    foreach ($error_msg as $msg) {
        showAlert("error", $msg);
    }
}
?>
