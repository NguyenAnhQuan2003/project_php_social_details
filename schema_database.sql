-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th12 14, 2025 lúc 04:39 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `schema_database`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `content`, `created_at`) VALUES
(7, 10, 10, 'sadasdas', '2025-12-12 17:25:18'),
(8, 11, 5, 'tét học liệu nhé', '2025-12-13 11:52:51'),
(9, 10, 5, 'sadsadas', '2025-12-14 10:12:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'text',
  `video_url` varchar(500) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `content`, `type`, `video_url`, `status`, `created_at`, `updated_at`) VALUES
(6, 10, 'MTP', 'Ca sĩ Việt Nam', 'text', NULL, 1, '2025-12-11 20:55:57', '2025-12-11 20:55:57'),
(7, 10, 'dsadsa', 'dsadsadas', 'video', 'vid_1765462088_5722.mov', 1, '2025-12-11 21:08:08', '2025-12-11 21:08:08'),
(8, 10, 'Đây là bài viết học tập', 'Hôm nay trời đẹp quá', 'text', NULL, 1, '2025-12-11 21:09:37', '2025-12-11 21:09:37'),
(9, 10, 'sadasdas', 'sdadsadasdas', 'video', 'vid_1765463545_6242.mov', 1, '2025-12-11 21:32:25', '2025-12-11 21:32:25'),
(10, 10, 'C++ Online', 'Học cùng Quân', 'video', 'vid_1765535062_4702.mov', 1, '2025-12-12 17:24:22', '2025-12-12 17:24:22'),
(11, 5, 'Học nào', 'sadsadasdasdas', 'video', 'vid_1765601557_9301.mov', 1, '2025-12-13 11:52:37', '2025-12-13 11:52:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `role_level` tinyint(4) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `role_level`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Observer', 1, 'Read-only, cannot add or edit notes.', '2025-12-09 20:52:10', '2025-12-09 20:52:10'),
(2, 'Contributor', 2, 'Can add notes and edit their own.', '2025-12-09 20:52:10', '2025-12-09 20:52:10'),
(3, 'Moderator', 3, 'Can edit or delete any notes but not manage members.', '2025-12-09 20:52:10', '2025-12-09 20:52:10'),
(4, 'Owner', 4, 'Full permission to manage project and members.', '2025-12-09 20:52:10', '2025-12-09 20:52:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `role_level` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role_id`, `role_level`, `created_at`, `updated_at`, `status`) VALUES
(5, 'admin', 'admin@example.com', '1', 4, 4, '2025-12-09 20:55:23', '2025-12-12 17:38:36', 'active'),
(6, 'mod', 'mod@example.com', '1', 3, 3, '2025-12-09 20:55:23', '2025-12-09 20:55:23', 'active'),
(7, 'userA', 'userA@example.com', '1', 2, 2, '2025-12-09 20:55:23', '2025-12-09 20:55:23', 'active'),
(8, 'viewA', 'viewA@example.com', '1', 1, 1, '2025-12-09 20:55:23', '2025-12-09 20:55:23', 'active'),
(9, 'anhquan', 'quan@gmail.com', '1', 1, 1, '2025-12-10 21:50:27', '2025-12-10 21:50:27', 'active'),
(10, 'quốc', 'aquan@gmail.com', '1', 1, 1, '2025-12-10 21:52:31', '2025-12-13 11:45:12', 'active'),
(11, 'testsession', 'session@gmail.com', '1', 1, 1, '2025-12-10 21:55:14', '2025-12-10 21:55:14', 'active'),
(12, 'anh', 'qa@gmail.com', '1', 1, 1, '2025-12-10 21:56:23', '2025-12-10 21:56:23', 'active'),
(13, 'dump', 'dump@gmail.com', '1', 1, 1, '2025-12-10 22:14:01', '2025-12-10 22:14:01', 'active');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_comments_post_id` (`post_id`),
  ADD KEY `idx_comments_user_id` (`user_id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_posts_user_id` (`user_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_role_id` (`role_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;