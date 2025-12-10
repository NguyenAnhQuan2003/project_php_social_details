<?php 
session_start();
include 'config.php';
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
        }
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .logo-img {
            height: 50px;
            width: auto;
        }
        .hero-section {
            min-height: 80vh;
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
    <!-- Header/Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <!-- Logo bên trái -->
            <a class="navbar-brand" href="index.php">
                <img src="https://img.freepik.com/premium-vector/play-button-media-music-icon-logo-design-colorful-media-play-technology-logo-element-music-audio-streaming-service-app-video-icon-logo_144543-1677.jpg" alt="ShareHub Logo" class="logo-img">
                <span class="ms-2 fw-bold fs-4">QQ social</span>
            </a>
            <!-- Button bên phải (khi chưa đăng nhập) -->
            <div class="ms-auto">
                <a href="./auth/login.php" class="btn btn-outline-primary me-2">Đăng Nhập</a>
                <a href="./auth/register.php" class="btn btn-primary">Đăng Ký</a>
            </div>
        </div>
    </nav>
    <section class="hero-section">
        <div>
            <h1 class="display-3 fw-bold mb-4">Chào mừng đến QQ social</h1>
            <p class="lead mb-5">Nơi chia sẻ bài viết, video và kết nối với mọi người</p>
            <a href="./posts/cu_post.php" class="btn btn-primary btn-lg">Bắt Đầu Đăng Bài Ngay</a>
        </div>
    </section>
<div class="container my-5">
        <h3 class="mb-4 fw-bold text-white">Bảng tin (Newsfeed)</h3>
        <div class="row">
            <?php
            $sql = 'SELECT posts.*, users.username 
                    FROM posts
                    JOIN users ON posts.user_id = users.id 
                    ORDER BY posts.created_at DESC';
            $query= mysqli_query($conn, $sql);
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <div class="col-md-6 col-lg-4 mb-4"> <div class="post-card h-100"> <img src="https://via.placeholder.com/400x200?text=Post+Image" class="w-100" alt="Post Image">
                            <div class="p-3">
                                <h5 class="fw-bold"><?php echo htmlspecialchars($row['title']); ?></h5>
                                <p class="text-muted">
                                    <?php 
                                    $content = htmlspecialchars($row['content']);
                                    if (strlen($content) > 100) {
                                        echo substr($content, 0, 100) . '...';
                                    } else {
                                        echo $content;
                                    }
                                    ?>
                                </p>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-primary fw-bold">
                                        <i class="bi bi-person-circle me-1"></i> 
                                        <?php echo htmlspecialchars($row['username']); ?>
                                    </small>
                                    <small class="text-muted">
                                        <?php echo date('d/m/Y', strtotime($row['created_at'])); ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="text-white text-center">Chưa có bài viết nào được chia sẻ.</p>';
            }
            ?>
        </div>
    </div>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>