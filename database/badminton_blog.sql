-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 04, 2025 lúc 12:30 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `badminton_blog`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `article`
--

CREATE TABLE `article` (
  `article_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `views` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `article`
--

INSERT INTO `article` (`article_id`, `title`, `content`, `author_id`, `category_id`, `created_at`, `views`) VALUES
(1, 'Hướng dẫn kỹ thuật cầm vợt đúng cách', 'Cách cầm vợt chuẩn giúp bạn đánh mạnh hơn và ít chấn thương...', 1, 1, '2025-12-04 17:14:07', 17),
(22, 'Kỹ thuật cầm vợt đúng cách cho người mới bắt đầu', 'Kỹ thuật cầm vợt là bước nền quan trọng nhất...\nLuyện tập cầm vợt đúng cách giúp tăng hiệu quả đánh.', 1, 1, '2025-12-04 18:12:19', 4),
(23, 'Hướng di chuyển cơ bản trên sân cho người chơi nghiệp dư', 'Hướng di chuyển là một trong những yếu tố quan trọng...\nLuyện tập di chuyển giúp tiết kiệm năng lượng.', 1, 1, '2025-12-04 18:12:19', 0),
(24, 'Các lỗi thường gặp khi chơi cầu lông', 'Nhiều người chơi thường mắc lỗi khi giao cầu, đỡ cầu...\nKhắc phục lỗi giúp cải thiện trình độ nhanh chóng.', 1, 1, '2025-12-04 18:12:19', 0),
(25, 'Cách tập cổ tay để tăng lực đánh', 'Cổ tay là bộ phận tạo sức mạnh chính...\nTập cổ tay mỗi ngày sẽ tăng lực smash.', 1, 1, '2025-12-04 18:12:19', 0),
(26, 'Cách tăng tốc độ phản xạ khi chơi cầu lông', 'Phản xạ nhanh giúp đỡ cầu và phòng thủ tốt hơn...\nNên tập bài tập phản xạ hằng ngày.', 1, 1, '2025-12-04 18:12:19', 0),
(27, 'Kỹ thuật Smash dành cho người mới', 'Smash cần lực từ vai, cổ tay và bước đà...\nLuyện tập đúng cách giúp tăng uy lực smash.', 1, 1, '2025-12-04 18:12:19', 0),
(28, 'Clear – cú đánh chiến thuật quan trọng', 'Clear giúp đẩy cầu về cuối sân đối thủ...\nNên kết hợp clear với drop để đa dạng hóa chiến thuật.', 1, 1, '2025-12-04 18:12:19', 0),
(29, 'Drop shot – cú bỏ nhỏ chiến thuật', 'Bỏ nhỏ giúp thay đổi nhịp độ trận đấu...\nNên đánh nhẹ và chính xác.', 1, 1, '2025-12-04 18:12:19', 2),
(30, 'Drive – kỹ thuật đánh ngang tốc độ cao', 'Drive được dùng nhiều trong đánh đôi...\nCần luyện phản xạ và lực cổ tay.', 1, 1, '2025-12-04 18:12:19', 0),
(31, 'Cách chọn vợt cầu lông phù hợp', 'Vợt cầu lông có nhiều loại như đầu nhẹ, đầu nặng...\nNên chọn theo trình độ và phong cách chơi.', 1, 1, '2025-12-04 18:12:19', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`category_id`, `name`, `description`) VALUES
(1, 'Kỹ thuật cơ bản', 'Các kỹ thuật nền tảng trong cầu lông');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `article_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `status` enum('pending','approved') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comment`
--

INSERT INTO `comment` (`comment_id`, `article_id`, `user_id`, `content`, `status`, `created_at`) VALUES
(2, 1, 2, 'gggggggggggggggggggggggg', 'approved', '2025-12-04 17:41:59'),
(3, 1, 2, 'gggggggggggggggggg', 'approved', '2025-12-04 18:27:18'),
(4, 22, 2, 'aaaaaaaaaaaaaaaaaaaaaaa', 'approved', '2025-12-04 18:27:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('ADMIN','USER') DEFAULT 'USER',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`user_id`, `username`, `password_hash`, `full_name`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$nrgAkCOdjjY7D37k.Px2h.TWV3u/pmzltVas7xW/2KX1o5EjVGO/m', 'Quản trị viên', 'ADMIN', '2025-12-04 17:14:07'),
(2, 'admin1', '$2y$10$Z5GtmHvfF0zL37ysTEV/L.ixftV5wdVYyD4bpNSjTIp6tFpcCG95e', 'huy ha', 'USER', '2025-12-04 17:25:44'),
(13, 'user1', '123456', 'Nguyễn Văn A', 'USER', '2025-12-04 18:11:00'),
(14, 'user2', '123456', 'Trần Thị B', 'USER', '2025-12-04 18:11:00'),
(15, 'user3', '123456', 'Lê Thị C', 'USER', '2025-12-04 18:11:00'),
(16, 'user4', '123456', 'Phạm Văn D', 'USER', '2025-12-04 18:11:00'),
(17, 'user5', '123456', 'Hoàng Thị E', 'USER', '2025-12-04 18:11:00'),
(18, 'user6', '123456', 'Bùi Quang F', 'USER', '2025-12-04 18:11:00'),
(19, 'user7', '123456', 'Đặng Thị G', 'USER', '2025-12-04 18:11:00'),
(20, 'user8', '123456', 'Phạm Hoàng H', 'USER', '2025-12-04 18:11:00'),
(21, 'user9', '123456', 'Trương Minh K', 'USER', '2025-12-04 18:11:00');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `article`
--
ALTER TABLE `article`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`article_id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
