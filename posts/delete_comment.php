<?php
session_start();
include '../config.php';

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Kiểm tra xem có comment_id hay không
if (!isset($_GET['comment_id']) || !is_numeric($_GET['comment_id'])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['post_id']) || !is_numeric($_GET['post_id'])) {
    header("Location: ../index.php");
    exit();
}

$comment_id = intval($_GET['comment_id']);
$post_id = intval($_GET['post_id']);
$user_id = $_SESSION['user_id'];
$role_level = $_SESSION['role_level'] ?? 1;

// Lấy thông tin bình luận
$sql = "SELECT * FROM comments WHERE id = $comment_id";
$query = mysqli_query($conn, $sql);

if (mysqli_num_rows($query) == 0) {
    header("Location: ../index.php");
    exit();
}

$comment = mysqli_fetch_assoc($query);

// Kiểm tra quyền xoá bình luận
// Owner (level 4) và Moderator (level 3) có thể xoá tất cả bình luận
// Người dùng có thể xoá bình luận của chính mình
$can_delete = false;
if ($role_level >= 3) { // Owner hoặc Moderator
    $can_delete = true;
} elseif ($comment['user_id'] == $user_id) { // Chủ sở hữu bình luận
    $can_delete = true;
}

if (!$can_delete) {
    header("Location: detailed_post.php?id=$post_id");
    exit();
}

// Xoá bình luận
$delete_sql = "DELETE FROM comments WHERE id = $comment_id";

if (mysqli_query($conn, $delete_sql)) {
    header("Location: detailed_post.php?id=$post_id&message=Bình luận đã được xoá thành công!");
    exit();
} else {
    header("Location: detailed_post.php?id=$post_id&error=Lỗi: Không thể xoá bình luận!");
    exit();
}
?>
