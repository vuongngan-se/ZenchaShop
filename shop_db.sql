-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:4036
-- Thời gian đã tạo: Th10 13, 2025 lúc 02:43 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Cơ sở dữ liệu: `shop_db`


--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `price`, `qty`) VALUES
(0, 0, 18, 55, 1),
(5, 0, 4, 120, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `rating` int(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `product_id`, `user_id`, `comment`, `rating`, `date`) VALUES
(2, 2, 4, 'abc', 0, '2024-11-13 14:47:47'),
(3, 2, 4, 'abc', 0, '2024-11-13 14:50:17'),
(7, 2, 4, 'T', 1, '2024-11-23 13:56:45'),
(8, 2, 4, 'Tốt', 3, '2024-11-23 13:57:01'),
(9, 2, 4, 'Tốt', 3, '2024-11-23 13:57:39'),
(10, 2, 4, 'Ngon', 2, '2024-11-23 14:02:13'),
(11, 2, 4, 'Ngon', 2, '2024-11-23 14:03:33'),
(12, 3, 4, 'Tốt', 5, '2024-11-26 07:57:57'),
(13, 3, 4, '3', 3, '2024-11-26 07:58:05'),
(14, 2, 4, 'h', 5, '2024-12-23 15:47:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`id`, `name`) VALUES
(1, 'Trà kg'),
(2, 'Trà gói');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_code` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `number` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `address_type` varchar(50) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` enum('pending','confirmed','canceled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_code`, `user_id`, `name`, `number`, `email`, `address`, `address_type`, `method`, `date`, `status`) VALUES
('ORDER_67330e9654875', 4, 'Trà My', '098723341', 'Q@gmail.com', 'Hiền An, Phú Lộc, Huế, Việt Nam, 110022', 'home', 'cash on delivery', '2025-11-12 00:00:00', 'confirmed'),
('ORDER_67330f7e52430', 4, 'Trà My', '1234545677', 'Q@gmail.com', 'Hiền An, Phú Lộc, Huế, Việt Nam, 110022', 'home', 'cash on delivery', '2025-11-12 00:00:00', 'confirmed'),
('ORDER_673310c98618f', 4, 'Trà My', '1234566', 'Q@gmail.com', 'Hiền An, Phú Lộc, Huế, Việt Nam, 110022', 'home', 'cash on delivery', '2025-11-12 00:00:00', 'confirmed'),
('ORDER_6734bff0979ab', 4, 'Trà My', '12345566', 'anh@gmail.com', 'Thôn 1, Xã 2, Quảng Trị, Việt Nam, 110022', 'home', 'paytm', '2025-11-13 00:00:00', 'confirmed');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_code` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_code`, `user_id`, `product_id`, `price`, `qty`, `name`) VALUES
(1,  'ORDER_67330e9654875', 4, 2, 280.00, 1, 'Trà Sen Tây Hồ'),
(2,  'ORDER_67330e9654875', 4, 3, 450.00, 1, 'Matcha Nguyên Chất Uji'),
(3,  'ORDER_67330e9654875', 4, 4, 350.00, 1, 'Trà Ô Long Tuyết'),
(4,  'ORDER_67330f7e52430', 4, 2, 280.00, 1, 'Trà Sen Tây Hồ'),
(5,  'ORDER_67330f7e52430', 4, 3, 450.00, 1, 'Matcha Nguyên Chất Uji'),
(6,  'ORDER_67330f7e52430', 4, 4, 350.00, 1, 'Trà Ô Long Tuyết'),
(7,  'ORDER_673310c98618f', 4, 5, 190.00, 1, 'Sencha Nhật Bản'),
(8,  'ORDER_673310c98618f', 4, 6, 180.00, 1, 'Trà Ô Long Cổ Truyền'),
(9,  'ORDER_673310c98618f', 4, 7, 260.00, 1, 'Hồng Trà Shan Tuyết'),
(10, 'ORDER_673310c98618f', 4, 2, 280.00, 1, 'Trà Sen Tây Hồ'),
(11, 'ORDER_6734bff0979ab', 4, 2, 280.00, 1, 'Trà Sen Tây Hồ'),
(12, 'ORDER_6734bff0979ab', 4, 5, 190.00, 1, 'Sencha Nhật Bản'),
(13, 'ORDER_6739c5d3c376d', 4, 2, 280.00, 2, 'Trà Sen Tây Hồ'),
(14, 'ORDER_673af26e3c0bf', 4, 2, 280.00, 3, 'Trà Sen Tây Hồ'),
(15, 'ORDER_67405758e2284', 4, 2, 280.00, 4, 'Trà Sen Tây Hồ'),
(16, 'ORDER_67456e1fef294', 4, 2, 280.00, 2, 'Trà Sen Tây Hồ'),
(17, 'ORDER_67456e1fef294', 4, 3, 450.00, 2, 'Matcha Nguyên Chất Uji'),
(18, 'ORDER_67456e1fef294', 4, 4, 350.00, 1, 'Trà Ô Long Tuyết'),
(19, 'ORDER_6745796a8bb4f', 4, 3, 450.00, 2, 'Matcha Nguyên Chất Uji'),
(20, 'ORDER_67457bbda9f5b', 4, 4, 350.00, 1, 'Trà Ô Long Tuyết'),
(21, 'ORDER_67457cc4409d9', 4, 7, 260.00, 1, 'Hồng Trà Shan Tuyết'),
(22, 'ORDER_674705b809ff7', 4, 4, 350.00, 1, 'Trà Ô Long Tuyết'),
(23, 'ORDER_6767ae260b38b', 5434, 4, 350.00, 1, 'Trà Ô Long Tuyết'),
(24, 'ORDER_6767ae260b38b', 5434, 12, 240.00, 1, 'Trà Thiết Quan Âm'),
(25, 'ORDER_67697fe890523', 4, 6, 180.00, 3, 'Trà Ô Long Cổ Truyền'),
(26, 'ORDER_676a3a1390c67', 4, 16, 150.00, 1, 'Matcha Pha Latte');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `product_detail` varchar(500) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `iddm` int(11) DEFAULT NULL,
  `sold` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--
INSERT INTO `products` (`id`, `name`, `price`, `image`, `product_detail`, `quantity`, `iddm`, `sold`) VALUES
(2, 'Trà Sen Tây Hồ', 280, '20.jpg', 'Trà Sen Tây Hồ truyền thống, hương thơm tinh tế của hoa sen tự nhiên, vị chát dịu, hậu ngọt sâu. Mỗi ký là hương thơm của hàng nghìn bông sen.', 5, 1, 0),
(3, 'Matcha Nguyên Chất Uji', 450, '21.jpg', 'Matcha cao cấp từ Uji, Nhật Bản. Bột mịn, màu xanh ngọc bích tươi sáng, hương thơm cỏ non và vị Umami đậm đà, không chát gắt.', 50, 3, 5),
(4, 'Trà Ô Long Tuyết', 350, '22.jpg', 'Trà Ô Long được chế biến đặc biệt, có lớp "tuyết" tự nhiên bao phủ. Hương thơm núi rừng và hoa quả, vị ngọt thanh, tinh khiết, hậu kéo dài.', 35, 1, 3),
(5, 'Sencha Nhật Bản', 190, '23.jpg', 'Trà xanh Sencha phổ biến của Nhật. Nước trà xanh tươi, hương thơm lá non, vị thanh mát, chát dịu nhẹ, giữ trọn dưỡng chất trà xanh.', 60, 3, 2),
(6, 'Trà Ô Long Cổ Truyền', 180, '24.jpg', 'Ô Long truyền thống Việt Nam. Viên trà tròn, màu xanh lục. Nước vàng hổ phách, hương hoa quả, vị chát dịu, hậu ngọt béo ngậy.', 45, 1, 6),
(7, 'Hồng Trà Shan Tuyết', 260, '25.jpg', 'Hồng trà (Black Tea) chế biến từ búp Shan Tuyết cổ thụ, sợi trà nâu bóng. Nước hồng ngọc, hương mật ong và trái cây chín mọng, vị ngọt thanh.', 40, 1, 1),
(8, 'Genmaicha (Trà Gạo Lứt Rang)', 120, '26.jpg', 'Trà xanh Nhật Bản pha trộn với gạo lứt rang. Hương thơm bùi của gạo, vị ấm áp, rất dễ uống, thường được dùng hàng ngày.', 50, 3, 5),
(9, 'Trà Bancha Nhật Bản', 90, '27.jpg', 'Trà xanh Bancha Nhật, dùng lá trưởng thành. Vị nhẹ, ít caffein hơn các loại trà khác, thích hợp uống sau bữa ăn.', 80, 3, 9),
(10, 'Trà Nõn Tôm (Việt Nam)', 220, '28.png', 'Trà xanh nõn tôm chất lượng cao của Việt Nam. Sợi nhỏ xoăn, nước vàng xanh. Hương cốm non mạnh mẽ, vị tiền chát đậm, hậu ngọt sâu.', 55, 1, 7),
(11, 'Matcha Trà Đạo', 300, '30.jpg', 'Matcha dùng cho Trà đạo (Chado). Bột siêu mịn, hương thơm đặc trưng, màu xanh đậm. Phù hợp cho việc đánh trà (whisking).', 40, 3, 0),
(12, 'Trà Thiết Quan Âm', 240, '31.jpeg', 'Trà Ô Long Thiết Quan Âm (Tie Guan Yin). Sợi kết xoăn, màu xanh lục. Hương hoa lan dịu dàng, vị chát êm, hậu ngọt thanh.', 30, 1, 1),
(13, 'Trà Cổ Thụ Tà Xùa', 420, '32.jpg', 'Trà xanh từ cây chè cổ thụ Tà Xùa, sợi to xốp, mang hương vị khoáng chất và hoa cỏ dại của núi đồi Tây Bắc.', 25, 1, 0),
(14, 'Gyokuro Nhật Bản', 650, '33.jpg', 'Trà xanh Gyokuro cao cấp nhất của Nhật, được che nắng trước thu hoạch. Hương thơm Umami đậm đà, vị ngọt, ít chát, nước xanh đậm.', 15, 3, 0),
(15, 'Hojicha (Trà Rang)', 110, '34.png', 'Trà xanh Nhật được rang ở nhiệt độ cao. Màu nước nâu đỏ, hương thơm rang bùi, vị nhẹ, hầu như không có caffein.', 40, 3, 0),
(16, 'Matcha Pha Latte', 150, '35.jpg', 'Loại Matcha kinh tế, phù hợp cho pha chế các món đồ uống như Matcha Latte, sinh tố hoặc làm bánh.', 35, 3, 1),
(17, 'Trà Gừng Việt Nam', 80, '36.webp', 'Trà hòa tan hương Gừng tự nhiên, ấm nóng, tốt cho sức khỏe. Dạng gói tiện lợi.', 50, 1, 0),
(18, 'Kukicha (Trà Cành)', 130, '36.jpg', 'Trà Nhật Bản làm từ cành và cuống của cây trà. Hương thơm nhẹ, vị tươi mát, rất ít caffein.', 40, 3, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `user_type` int(11) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `reset_token`, `reset_token_expire`) VALUES
(3, 'B', 'B@gmail.com', '$2y$10$d4YR6b1rfHDMNt8FrjXvNODf8Iamy8x9CInzk0VK40TdQm3ZJTQlK', 0, NULL, NULL),
(4, 'Q', 'Q@gmail.com', '$2y$10$HsRBO67vJ32GZ9QPBBVcr.33rLXJets9ju98tNvT/wvlYq8egR1SS', 0, NULL, NULL),
(5, 'A', 'A@gmail.com', '$2y$10$.UQhySBVgDBBbOt42jdla.P3UX7TxEeWbNFXjfc.0fUyrcBPhL5nK', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `price`) VALUES
(54, 'CWYhCB8a4RqqYAFpl71', '4', 0),
(67, '4', '3', 50),
(0, '5434', '4', 120);
--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_code`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_code` (`order_code`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_danhmuc` (`iddm`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--
ALTER TABLE `cart` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5436;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_code`) REFERENCES `orders` (`order_code`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_danhmuc` FOREIGN KEY (`iddm`) REFERENCES `danhmuc` (`id`) ON DELETE CASCADE;
COMMIT;
