<?php
session_start();
include '../config.php';

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Kiểm tra xem có post_id hay không
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}

$post_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];
$role_level = $_SESSION['role_level'] ?? 1;

// Lấy thông tin bài đăng
$sql = "SELECT * FROM posts WHERE id = $post_id";
$query = mysqli_query($conn, $sql);

if (mysqli_num_rows($query) == 0) {
    header("Location: ../index.php");
    exit();
}

$post = mysqli_fetch_assoc($query);

// Kiểm tra quyền sửa bài đăng
// Owner (level 4) có thể sửa tất cả bài đăng
// Contributor (level 2) chỉ có thể sửa bài đăng của mình
$can_edit = false;
if ($role_level == 4) { // Owner
    $can_edit = true;
} elseif ($role_level == 2 && $post['user_id'] == $user_id) { // Contributor sửa bài của mình
    $can_edit = true;
}

if (!$can_edit) {
    header("Location: ../index.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    
    if (empty($title) || empty($content)) {
        $error = "Vui lòng điền đầy đủ thông tin!";
    } else {
        $title = mysqli_real_escape_string($conn, $title);
        $content = mysqli_real_escape_string($conn, $content);
        
        $update_sql = "UPDATE posts SET title = '$title', content = '$content', updated_at = NOW() WHERE id = $post_id";
        
        if (mysqli_query($conn, $update_sql)) {
            $success = "Cập nhật bài đăng thành công!";
            // Redirect sau 1 giây
            header("Refresh: 1; url=detailed_post.php?id=$post_id");
        } else {
            $error = "Lỗi: " . mysqli_error($conn);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Bài Đăng - QQ Social</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            margin: 0;
            padding-top: 70px;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .logo-img {
            height: 45px;
            width: auto;
        }
        .edit-container {
            max-width: 800px;
            margin: 2rem auto;
        }
        .edit-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            padding: 2rem;
        }
        .form-label {
            font-weight: 600;
            color: #333;
        }
        .form-control:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 0 0.2rem rgba(106, 17, 203, 0.25);
        }
        .btn-submit {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
            color: white;
            padding: 12px 30px;
        }
        .btn-submit:hover {
            background: linear-gradient(to right, #5a0fbb, #1565ec);
            color: white;
        }
        .btn-cancel {
            color: #999;
        }
        .btn-cancel:hover {
            color: #6a11cb;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="../index.php">
                <img src="https://img.freepik.com/premium-vector/play-button-media-music-icon-logo-design-colorful-media-play-technology-logo-element-music-audio-streaming-service-app-video-icon-logo_144543-1677.jpg" alt="ShareHub Logo" class="logo-img">
                <span class="ms-2 fw-bold fs-4 text-primary">QQ social</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span class="me-3 fw-bold text-dark">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        <a href="../auth/logout.php" class="btn btn-outline-danger btn-sm">Đăng Xuất</a>
                    <?php else: ?>
                        <a href="../auth/login.php" class="btn btn-outline-primary me-2">Đăng Nhập</a>
                        <a href="../auth/register.php" class="btn btn-primary">Đăng Ký</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="edit-container">
        <div class="mb-3">
            <a href="detailed_post.php?id=<?php echo $post_id; ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Quay Lại
            </a>
        </div>

        <div class="edit-card">
            <h2 class="mb-4">
                <i class="bi bi-pencil-square me-2"></i>Sửa Bài Đăng
            </h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i><?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?php echo $success; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu Đề</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Nội Dung</label>
                    <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-submit">
                        <i class="bi bi-check-lg me-2"></i>Cập Nhật
                    </button>
                    <a href="detailed_post.php?id=<?php echo $post_id; ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg me-2"></i>Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
