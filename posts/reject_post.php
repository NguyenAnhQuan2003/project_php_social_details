<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}

$post_id = intval($_GET['id']);
$user_role = $_SESSION['role_level'] ?? 1;

// Chỉ Owner và Moderator có quyền từ chối
if ($user_role < 3) {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT * FROM posts WHERE id = $post_id";
$query = mysqli_query($conn, $sql);

if (mysqli_num_rows($query) == 0) {
    header("Location: ../index.php");
    exit();
}

$post = mysqli_fetch_assoc($query);

// Cập nhật status thành -1 (bị từ chối)
$update_sql = "UPDATE posts SET status = -1 WHERE id = $post_id";

if (mysqli_query($conn, $update_sql)) {
    header("Location: ../index.php?message=Bài đăng đã bị từ chối!");
    exit();
} else {
    header("Location: ../index.php?error=Lỗi: Không thể từ chối bài đăng!");
    exit();
}
?>
