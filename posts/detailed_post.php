<?php
session_start();
include '../config.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}
$post_id = intval($_GET['id']);
$sql = "SELECT posts.*, users.username 
        FROM posts 
        JOIN users ON posts.user_id = users.id
        WHERE posts.id = $post_id";

$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) == 0) {
    header("Location: ../index.php");
    exit();
}
$post = mysqli_fetch_assoc($query);
$comment_sql = "SELECT comments.*, users.username 
                FROM comments 
                JOIN users ON comments.user_id = users.id
                WHERE comments.post_id = $post_id
                ORDER BY comments.created_at ASC";

$comment_query = mysqli_query($conn, $comment_sql);

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../auth/login.php");
        exit();
    }
    
    $content = isset($_POST['comment_content']) ? trim($_POST['comment_content']) : '';
    
    if (empty($content)) {
        $error = "Vui lòng nhập nội dung bình luận!";
    } else {
        $user_id = $_SESSION['user_id'];
        $content = mysqli_real_escape_string($conn, $content);
        $insert_sql = "INSERT INTO comments (post_id, user_id, content, created_at) 
                       VALUES ($post_id, $user_id, '$content', NOW())";
        if (mysqli_query($conn, $insert_sql)) {
            header("Location: detailed_post.php?id=" . $post_id);
            exit();
        } else {
            $error = "Lỗi: Không thể lưu bình luận!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - QQ Social</title>
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
        .post-detail-container {
            max-width: 800px;
            margin: 2rem auto;
        }
        .post-detail-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        .post-header {
            padding: 1.5rem 2rem 0 2rem;
            border-bottom: none;
        }
        .post-title {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .post-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 0;
        }
        .post-content {
            padding: 1rem 2rem 2rem 2rem;
            line-height: 1.8;
            font-size: 1.1rem;
            color: #555;
            text-align: justify;
            word-wrap: break-word;
            word-break: break-word;
            white-space: pre-wrap;
            overflow-wrap: break-word;
        }
        .post-video {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
        .video-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.8);
        }
        .comments-section {
            border-top: 1px solid #e0e0e0;
            padding: 2rem;
            background-color: #f9f9f9;
        }
        .comment {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 4px solid #6a11cb;
        }
        .comment-author {
            font-weight: bold;
            color: #6a11cb;
            margin-bottom: 0.5rem;
        }
        .comment-time {
            font-size: 0.85rem;
            color: #999;
        }
        .comment-content {
            color: #666;
            margin-top: 0.5rem;
        }
        .btn-back {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
            color: white;
        }
        .btn-back:hover {
            background: linear-gradient(to right, #5a0fbb, #1565ec);
            color: white;
        }
        .type-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }
        .type-video {
            background-color: #ffe6e6;
            color: #c00;
        }
        .type-text {
            background-color: #e6f2ff;
            color: #0066cc;
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
    <div class="post-detail-container">
        <div class="mb-3">
            <a href="../index.php" class="btn btn-back">
                <i class="bi bi-arrow-left me-2"></i>Quay Lại
            </a>
        </div>
        <div class="post-detail-card">
            <div class="post-header">
                <div class="mb-3">
                    <span class="type-badge <?php echo $post['type'] == 'video' ? 'type-video' : 'type-text'; ?>">
                        <?php if ($post['type'] == 'video'): ?>
                            <i class="bi bi-play-circle-fill me-1"></i>Video
                        <?php else: ?>
                            <i class="bi bi-file-text-fill me-1"></i>Bài Viết
                        <?php endif; ?>
                    </span>
                </div>
                <h1 class="post-title">
                    <?php echo htmlspecialchars($post['title']); ?>
                </h1>
                <div class="post-meta">
                    <div>
                        <small class="text-muted">
                            <i class="bi bi-person-circle me-1"></i>
                            <span class="text-primary fw-bold"><?php echo htmlspecialchars($post['username']); ?></span>
                        </small>
                    </div>
                    <div>
                        <small class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            <?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?>
                        </small>
                    </div>
                </div>
            </div>
            <?php if ($post['type'] == 'video' && !empty($post['video_url'])): ?>
                <video class="post-video" controls style="width: 100%; height: auto; display: block;">
                    <source src="../uploads/<?php echo htmlspecialchars($post['video_url']); ?>" type="video/mp4">
                </video>
            <?php endif; ?>
            <div class="post-content">
                <?php echo nl2br(htmlspecialchars($post['content'])); ?>
            </div>
            <div class="comments-section">
                <h4 class="mb-4">
                    <i class="bi bi-chat-left-dots me-2"></i>Bình Luận (<?php echo mysqli_num_rows($comment_query); ?>)
                </h4>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form method="POST" class="mb-4">
                        <div class="mb-3">
                            <textarea class="form-control" name="comment_content" rows="3" placeholder="Viết bình luận của bạn..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-2"></i>Gửi Bình Luận
                        </button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <a href="../auth/login.php" class="alert-link">Đăng nhập</a> để bình luận
                    </div>
                <?php endif; ?>
                <?php if (mysqli_num_rows($comment_query) > 0): ?>
                    <hr>
                    <?php 
                    $comment_query = mysqli_query($conn, "SELECT comments.*, users.username 
                                                         FROM comments 
                                                         JOIN users ON comments.user_id = users.id
                                                         WHERE comments.post_id = $post_id
                                                         ORDER BY comments.created_at ASC");
                    while ($comment = mysqli_fetch_assoc($comment_query)): ?>
                        <div class="comment">
                            <div class="comment-author">
                                <i class="bi bi-person-circle me-2"></i><?php echo htmlspecialchars($comment['username']); ?>
                            </div>
                            <div class="comment-time">
                                <?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?>
                            </div>
                            <div class="comment-content">
                                <?php echo htmlspecialchars($comment['content']); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-muted text-center">Chưa có bình luận nào.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
