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
$user_id = $_SESSION['user_id'];
$role_level = $_SESSION['role_level'] ?? 1;


$sql = "SELECT * FROM posts WHERE id = $post_id";
$query = mysqli_query($conn, $sql);

if (mysqli_num_rows($query) == 0) {
    header("Location: ../index.php");
    exit();
}

$post = mysqli_fetch_assoc($query);


$can_delete = false;
if ($role_level >= 3) {
    $can_delete = true;
} elseif ($role_level == 2 && $post['user_id'] == $user_id) {
    $can_delete = true;
}

if (!$can_delete) {
    header("Location: ../index.php");
    exit();
}


$delete_sql = "DELETE FROM posts WHERE id = $post_id";

if (mysqli_query($conn, $delete_sql)) {
    header("Location: ../index.php?message=Bài đăng đã được xoá thành công!");
    exit();
} else {
    header("Location: detailed_post.php?id=$post_id&error=Lỗi: Không thể xoá bài đăng!");
    exit();
}
