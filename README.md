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

- <img width="940" height="467" alt="image" src="https://github.com/user-attachments/assets/38bba856-8a89-4797-b6ee-3b9e00c0d853" />
<img width="940" height="467" alt="image" src="https://github.com/user-attachments/assets/2992f88b-622d-4592-a170-f00a0680e1db" />
<img width="940" height="466" alt="image" src="https://github.com/user-attachments/assets/165d3118-c32c-441f-8d71-a978c3df6272" />
<img width="940" height="469" alt="image" src="https://github.com/user-attachments/assets/97aa3f89-bbc0-4802-8b2f-e573f6c19606" />
<img width="940" height="461" alt="image" src="https://github.com/user-attachments/assets/89379d33-7784-45e1-a8b3-1369c57863c1" />
<img width="940" height="464" alt="image" src="https://github.com/user-attachments/assets/1c19b2bd-3b4b-4b72-8087-6f8221922213" />
<img width="460" height="592" alt="image" src="https://github.com/user-attachments/assets/1cb6f4d4-a654-46bd-82d5-22b73f6a9ac9" />




