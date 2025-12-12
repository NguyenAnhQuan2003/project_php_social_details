<?php
session_start();
include 'config.php';
if (isset($_SESSION['user_id'])) {
    $link_action = "./posts/cu_post.php";
} else {
    $link_action = "./auth/register.php";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShareHub - Chia Sẻ Bài Viết & Video</title>
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

        .hero-section {
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .btn-primary {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
            padding: 12px 30px;
            font-size: 1.2rem;
        }

        .post-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            margin-bottom: 2rem;
            transition: transform 0.3s;
        }

        .post-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
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
                        <a href="./auth/logout.php" class="btn btn-outline-danger btn-sm">Đăng Xuất</a>
                    <?php else: ?>
                        <a href="./auth/login.php" class="btn btn-outline-primary me-2">Đăng Nhập</a>
                        <a href="./auth/register.php" class="btn btn-primary">Đăng Ký</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <section class="hero-section">
        <div class="container">
            <h1 class="display-3 fw-bold mb-4">Chào mừng đến QQ social</h1>
            <p class="lead mb-5">Nơi chia sẻ bài viết, video và kết nối với mọi người</p>
            <a href="<?php echo $link_action; ?>" class="btn btn-light text-primary fw-bold btn-lg">Bắt Đầu Đăng Bài Ngay</a>
        </div>
    </section>
    <div class="container my-5">
        <div class="mb-4 d-flex justify-content-center">
            <a href="index.php" class="btn btn-outline-light me-2 <?php echo !isset($_GET['type']) ? 'active' : ''; ?>">Tất cả</a>
            <a href="index.php?type=text" class="btn btn-outline-light me-2 <?php echo (isset($_GET['type']) && $_GET['type'] == 'text') ? 'active' : ''; ?>">Bài viết</a>
            <a href="index.php?type=video" class="btn btn-outline-light <?php echo (isset($_GET['type']) && $_GET['type'] == 'video') ? 'active' : ''; ?>">Video</a>
        </div>
        <div class="row">
            <?php
            $type_filter = $_GET['type'] ?? '';
            $sql = "SELECT posts.*, users.username 
                    FROM posts 
                    JOIN users ON posts.user_id = users.id";
            if ($type_filter == 'text' || $type_filter == 'video') {
                $safe_type = mysqli_real_escape_string($conn, $type_filter);
                $sql .= " WHERE posts.type = '$safe_type'";
            }
            $sql .= " ORDER BY posts.created_at DESC";
            $query = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    $comment_count_sql = "SELECT COUNT(*) as count FROM comments WHERE post_id = " . $row['id'];
                    $comment_count_result = mysqli_query($conn, $comment_count_sql);
                    $comment_count = mysqli_fetch_assoc($comment_count_result)['count'];
            ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="post-card h-100">
                            <?php if ($row['type'] == 'video'): ?>
                                <img src="https://via.placeholder.com/400x200?text=VIDEO+POST" class="w-100">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/400x200?text=News" class="w-100">
                            <?php endif; ?>
                            <div class="p-3">
                                <h5 class="fw-bold">
                                    <?php if ($row['type'] == 'video') echo '<i class="bi bi-play-circle-fill text-danger"></i> '; ?>
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </h5>
                                <p class="text-muted">
                                    <?php echo mb_strimwidth(htmlspecialchars($row['content']), 0, 45, "..."); ?>
                                </p>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-primary fw-bold">
                                        <i class="bi bi-person-circle me-1"></i>
                                        <?php echo htmlspecialchars($row['username']); ?>
                                    </small>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        <?php echo date('d/m/Y', strtotime($row['created_at'])); ?>
                                    </small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-info">
                                        <i class="bi bi-chat-dots me-1"></i>
                                        <?php echo $comment_count; ?> bình luận
                                    </small>
                                </div>
                                <a href="./posts/detailed_post.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm w-100">
                                    <i class="bi bi-eye me-2"></i>Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="text-center text-white">Không tìm thấy bài viết nào.</p>';
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>