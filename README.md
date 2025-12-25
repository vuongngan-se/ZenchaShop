# Hướng dẫn cài đặt và sử dụng ZenchaShop

Đây là một dự án website thương mại điện tử bán trà.

## Yêu cầu hệ thống
- XAMPP (với Apache, MySQL, và PHP)
- Composer

## Các bước cài đặt

1.  **Tải mã nguồn:**
    - Clone repository này hoặc tải file ZIP về và giải nén.
    - Đặt thư mục `ZenchaShop` vào trong thư mục `htdocs` của XAMPP (ví dụ: `C:\xampp\htdocs\ZenchaShop`).

2.  **Cài đặt cơ sở dữ liệu:**
    - Mở XAMPP Control Panel và khởi động Apache và MySQL.
    - Truy cập `http://localhost/phpmyadmin`.
    - Tạo một cơ sở dữ liệu mới với tên là `shop_db`.
    - Chọn cơ sở dữ liệu `shop_db` vừa tạo, vào tab "Import".
    - Nhấn "Choose File" và chọn file `shop_db.sql` có trong thư mục dự án.
    - Nhấn "Go" để import dữ liệu.

3.  **Cài đặt dependencies:**
    - Mở terminal hoặc command prompt trong thư mục gốc của dự án (`C:\xampp\htdocs\ZenchaShop`).
    - Chạy lệnh sau để cài đặt các gói cần thiết:
      ```
      composer install
      ```

4.  **Truy cập trang web:**
    - Mở trình duyệt và truy cập vào địa chỉ: `http://localhost/ZenchaShop/home.php`
    - Bạn có thể bắt đầu sử dụng trang web.

## Tài khoản Admin
- Để truy cập trang quản trị, hãy vào: `http://localhost/ZenchaShop/login.php`
- Sử dụng tài khoản có sẵn trong database hoặc đăng ký một tài khoản mới và thay đổi `user_type` thành `admin` trong bảng `users` của database.
