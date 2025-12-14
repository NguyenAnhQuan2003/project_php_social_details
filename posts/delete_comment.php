<?php
session_start();
include '../config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}


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


$sql = "SELECT * FROM comments WHERE id = $comment_id";
$query = mysqli_query($conn, $sql);

if (mysqli_num_rows($query) == 0) {
    header("Location: ../index.php");
    exit();
}

$comment = mysqli_fetch_assoc($query);


$can_delete = false;
if ($role_level >= 3) {
    $can_delete = true;
} elseif ($comment['user_id'] == $user_id) {
    $can_delete = true;
}

if (!$can_delete) {
    header("Location: detailed_post.php?id=$post_id");
    exit();
}


$delete_sql = "DELETE FROM comments WHERE id = $comment_id";

if (mysqli_query($conn, $delete_sql)) {
    header("Location: detailed_post.php?id=$post_id&message=Bình luận đã được xoá thành công!");
    exit();
} else {
    header("Location: detailed_post.php?id=$post_id&error=Lỗi: Không thể xoá bình luận!");
    exit();
}
