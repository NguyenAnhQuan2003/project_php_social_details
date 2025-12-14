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

        .footer {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
            margin-top: auto;
            /* Đẩy footer xuống đáy */
            padding-top: 3rem;
            padding-bottom: 1rem;
        }

        .footer a {
            text-decoration: none;
            color: #666;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: #6a11cb;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(106, 17, 203, 0.3);">
                    <span style="color: white; font-weight: 900; font-family: sans-serif; font-size: 20px; letter-spacing: -1px;">QQ</span>
                </div>
                <span class="ms-2 fw-bold fs-4 text-primary">Education</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>

                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 rounded-pill px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5 text-primary"></i>
                                <span class="fw-bold text-dark">
                                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                                </span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2">
                                <li>
                                    <h6 class="dropdown-header">Tài khoản của tôi</h6>
                                </li>

                                <li>
                                    <a class="dropdown-item py-2" href="./user/profile.php">
                                        <i class="bi bi-gear-wide-connected me-2 text-secondary"></i> Cài đặt tài khoản
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item py-2" href="./auth/change_password.php">
                                        <i class="bi bi-key-fill me-2 text-warning"></i> Đổi mật khẩu
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li>
                                    <a class="dropdown-item py-2 text-danger fw-bold" href="./auth/logout.php">
                                        <i class="bi bi-box-arrow-right me-2"></i> Đăng Xuất
                                    </a>
                                </li>
                            </ul>
                        </div>

                    <?php else: ?>
                        <a href="./auth/login.php" class="btn btn-outline-primary me-2 rounded-pill px-4">Đăng Nhập</a>
                        <a href="./auth/register.php" class="btn btn-primary rounded-pill px-4">Đăng Ký</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <section class="hero-section">
        <div class="container">
            <h1 class="display-3 fw-bold mb-4">Chào mừng đến QQ Education</h1>
            <p class="lead mb-5">Nơi chia sẻ bài viết, video học liệu và kết nối với mọi người</p>
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
            $user_role = $_SESSION['role_level'] ?? 1;
            
            $sql = "SELECT posts.*, users.username 
                    FROM posts 
                    JOIN users ON posts.user_id = users.id";
            
            // Xây dựng điều kiện WHERE dựa trên quyền hạn
            $where_conditions = [];
            
            if ($user_role >= 3) { // Owner và Moderator: nhìn tất cả
                // Không cần điều kiện status
            } elseif ($user_role == 2) { // Contributor: nhìn bài được duyệt (status=1) hoặc bài của mình ở status 0 và -1
                $user_id = $_SESSION['user_id'];
                $where_conditions[] = "(posts.status = 1 OR (posts.user_id = $user_id AND posts.status IN (0, -1)))";
            } else { // Observer: chỉ nhìn bài được duyệt
                $where_conditions[] = "posts.status = 1";
            }
            
            // Thêm filter loại bài
            if ($type_filter == 'text' || $type_filter == 'video') {
                $safe_type = mysqli_real_escape_string($conn, $type_filter);
                $where_conditions[] = "posts.type = '$safe_type'";
            }
            
            if (!empty($where_conditions)) {
                $sql .= " WHERE " . implode(" AND ", $where_conditions);
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
                        <div class="post-card h-100 d-flex flex-column">
                            <?php if ($row['type'] == 'video' && !empty($row['video_url'])): ?>
                                <video class="w-100" style="height: 250px; object-fit: cover; background: #000;" controls>
                                    <source src="./uploads/<?php echo htmlspecialchars($row['video_url']); ?>" type="video/mp4">
                                </video>
                            <?php elseif ($row['type'] == 'video'): ?>
                                <img src="https://via.placeholder.com/400x200?text=VIDEO+POST" class="w-100">
                            <?php else: ?>
                                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 250px; display: flex; align-items: center; justify-content: center;">
                                    <div class="text-white text-center p-3">
                                        <i class="bi bi-file-text-fill" style="font-size: 3rem;"></i>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="p-3 flex-grow-1 d-flex flex-column">
                                <h5 class="fw-bold">
                                    <?php if ($row['type'] == 'video') echo '<i class="bi bi-play-circle-fill text-danger"></i> '; ?>
                                    <?php if ($row['type'] == 'text') echo '<i class="bi bi-file-text-fill text-primary"></i> '; ?>
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </h5>
                                <?php 
                                // Hiển thị badge status
                                $user_role = $_SESSION['role_level'] ?? 1;
                                $show_status = false;
                                
                                if ($user_role >= 3) { // Owner và Moderator: luôn hiển thị
                                    $show_status = true;
                                } elseif ($user_role == 2 && $row['status'] != 1) { // Contributor: hiển thị nếu chưa duyệt hoặc bị từ chối
                                    if ($row['user_id'] == $_SESSION['user_id']) {
                                        $show_status = true;
                                    }
                                }
                                
                                if ($show_status) {
                                    if ($row['status'] == 1) {
                                        echo '<span class="badge bg-success mb-2">✓ Đã duyệt</span>';
                                    } elseif ($row['status'] == 0) {
                                        echo '<span class="badge bg-warning mb-2">⏳ Chờ duyệt</span>';
                                    } elseif ($row['status'] == -1) {
                                        echo '<span class="badge bg-danger mb-2">✗ Bị từ chối</span>';
                                    }
                                }
                                ?>
                                <p class="text-muted flex-grow-1" style="word-wrap: break-word; overflow-wrap: break-word;">
                                    <?php echo mb_strimwidth(htmlspecialchars($row['content']), 0, 100, "..."); ?>
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
                                <?php 
                                // Nút duyệt/từ chối cho Owner và Moderator
                                $user_role = $_SESSION['role_level'] ?? 1;
                                if ($user_role >= 3) {
                                    echo '<div class="d-flex gap-2 mt-2">';
                                    if ($row['status'] != 1) {
                                        echo '<a href="./posts/approve_post.php?id=' . $row['id'] . '" class="btn btn-success btn-sm flex-grow-1">
                                                <i class="bi bi-check-lg me-1"></i>Duyệt
                                              </a>';
                                    }
                                    if ($row['status'] != -1) {
                                        echo '<a href="./posts/reject_post.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm flex-grow-1">
                                                <i class="bi bi-x-lg me-1"></i>Từ chối duyệt
                                              </a>';
                                    }
                                    echo '</div>';
                                }
                                ?>
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
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="#" class="d-flex align-items-center mb-3 text-decoration-none">
                        <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(106, 17, 203, 0.3);">
                            <span style="color: white; font-weight: 900; font-family: sans-serif; font-size: 20px; letter-spacing: -1px;">QQ</span>
                        </div>
                        <span class="fs-4 fw-bold text-primary ms-2">Education</span>
                    </a>
                    <p class="text-muted">
                        Nền tảng mạng xã hội giáo dục hàng đầu, nơi chia sẻ kiến thức, tài liệu và video học tập bổ ích cho cộng đồng.
                    </p>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Liên kết nhanh</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php"><i class="bi bi-chevron-right small me-2"></i>Trang chủ</a></li>
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right small me-2"></i>Về chúng tôi</a></li>
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right small me-2"></i>Điều khoản sử dụng</a></li>
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right small me-2"></i>Chính sách bảo mật</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h5 class="fw-bold mb-3">Liên hệ hỗ trợ</h5>
                    <p class="text-muted mb-2"><i class="bi bi-geo-alt-fill text-primary me-2"></i> Hà Nội, Việt Nam</p>
                    <p class="text-muted mb-2"><i class="bi bi-telephone-fill text-primary me-2"></i> 0912.345.678</p>
                    <p class="text-muted mb-3"><i class="bi bi-envelope-fill text-primary me-2"></i> contact@qqeducation.com</p>

                    <div class="d-flex gap-3">
                        <a href="#" class="fs-4 text-primary"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="fs-4 text-danger"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="fs-4 text-info"><i class="bi bi-twitter"></i></a>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start text-muted">
                    &copy; 2026 <strong>QQ Education</strong>. All Rights Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end text-muted">
                    Designed by Quan & Quoc
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>