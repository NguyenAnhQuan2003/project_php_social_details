<?php
session_start();

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

        .btn-primary:hover {
            opacity: 0.9;
        }

        .post-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            margin-bottom: 2rem;
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

                        <span class="me-3 fw-bold text-dark">
                            Hi, <?php echo $_SESSION['username']; ?>
                        </span>
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

            <a href="<?php echo $link_action; ?>" class="btn btn-light text-primary fw-bold btn-lg">
                Bắt Đầu Đăng Bài Ngay
            </a>
        </div>
    </section>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="post-card">
                    <img src="https://via.placeholder.com/400x250?text=Video+Example" class="w-100" alt="Video">
                    <div class="p-3">
                        <h5>Tiêu đề bài viết/video mẫu</h5>
                        <p class="text-muted">Mô tả ngắn gọn...</p>
                        <small class="text-muted">Đăng bởi: User123 • 1 giờ trước</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>