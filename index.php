<?php
session_start();
include 'config.php';
if (isset($_SESSION['user_id'])) {
    $link_action = "./posts/cu_post.php";
} else {
    $link_action = "./auth/register.php";
}

$limit = 6;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;
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
            min-height: 50vh;
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

        .search-bar {
            background: white;
            border-radius: 50px;
            padding: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .search-input {
            border: none;
            outline: none;
            box-shadow: none !important;
        }

        /* CSS cho Pagination */
        .page-link {
            color: #6a11cb;
            border: none;
            margin: 0 5px;
            border-radius: 5px;
            font-weight: bold;
        }

        .page-item.active .page-link {
            background-color: #6a11cb;
            border-color: #6a11cb;
        }

        .page-link:hover {
            color: #2575fc;
            background-color: #e9ecef;
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
                                <li><a class="dropdown-item py-2" href="./user/profile.php"><i class="bi bi-gear-wide-connected me-2 text-secondary"></i> Cài đặt tài khoản</a></li>
                                <li><a class="dropdown-item py-2" href="./auth/change_password.php"><i class="bi bi-key-fill me-2 text-warning"></i> Đổi mật khẩu</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item py-2 text-danger fw-bold" href="./auth/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Đăng Xuất</a></li>
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

        <div class="row justify-content-center mb-5">
            <div class="col-md-8 col-lg-6">
                <form action="index.php" method="GET" class="search-bar d-flex align-items-center">
                    <?php if (isset($_GET['type'])): ?>
                        <input type="hidden" name="type" value="<?php echo htmlspecialchars($_GET['type']); ?>">
                    <?php endif; ?>
                    <input type="text" name="search" class="form-control form-control-lg search-input ps-4"
                        placeholder="Bạn muốn tìm gì hôm nay?"
                        value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 m-1">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="mb-4 d-flex justify-content-center">
            <?php $search_param = isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>
            <a href="index.php?<?php echo substr($search_param, 1); ?>"
                class="btn btn-outline-light me-2 <?php echo !isset($_GET['type']) ? 'active' : ''; ?>">Tất cả</a>
            <a href="index.php?type=text<?php echo $search_param; ?>"
                class="btn btn-outline-light me-2 <?php echo (isset($_GET['type']) && $_GET['type'] == 'text') ? 'active' : ''; ?>">Bài viết</a>
            <a href="index.php?type=video<?php echo $search_param; ?>"
                class="btn btn-outline-light <?php echo (isset($_GET['type']) && $_GET['type'] == 'video') ? 'active' : ''; ?>">Video</a>
        </div>

        <div class="row">
            <?php
            $type_filter = $_GET['type'] ?? '';
            $search_query = $_GET['search'] ?? '';
            $user_role = $_SESSION['role_level'] ?? 1;

            $where_conditions = [];

            if ($user_role >= 3) {
            } elseif ($user_role == 2) {
                $user_id = $_SESSION['user_id'];
                $where_conditions[] = "(posts.status = 1 OR (posts.user_id = $user_id AND posts.status IN (0, -1)))";
            } else {
                $where_conditions[] = "posts.status = 1";
            }

            if ($type_filter == 'text' || $type_filter == 'video') {
                $safe_type = mysqli_real_escape_string($conn, $type_filter);
                $where_conditions[] = "posts.type = '$safe_type'";
            }

            if (!empty($search_query)) {
                $safe_search = mysqli_real_escape_string($conn, $search_query);
                $where_conditions[] = "(posts.title LIKE '%$safe_search%' OR posts.content LIKE '%$safe_search%')";
            }

            $sql_count = "SELECT COUNT(*) as total FROM posts JOIN users ON posts.user_id = users.id";
            if (!empty($where_conditions)) {
                $sql_count .= " WHERE " . implode(" AND ", $where_conditions);
            }
            $query_count = mysqli_query($conn, $sql_count);
            $row_count = mysqli_fetch_assoc($query_count);
            $total_records = $row_count['total'];
            $total_pages = ceil($total_records / $limit);



            $sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id";
            if (!empty($where_conditions)) {
                $sql .= " WHERE " . implode(" AND ", $where_conditions);
            }
            $sql .= " ORDER BY posts.created_at DESC LIMIT $offset, $limit"; // Thêm LIMIT vào cuối
            $query = mysqli_query($conn, $sql);

            if ($query && mysqli_num_rows($query) > 0) {
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
                                    <?php
                                    $title_display = htmlspecialchars($row['title']);
                                    if (!empty($search_query)) {
                                        $title_display = preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<span class="bg-warning text-dark">$1</span>', $title_display);
                                    }
                                    echo $title_display;
                                    ?>
                                </h5>
                                <?php
                                $user_role = $_SESSION['role_level'] ?? 1;
                                $show_status = false;
                                if ($user_role >= 3) {
                                    $show_status = true;
                                } elseif ($user_role == 2 && $row['status'] != 1) {
                                    if ($row['user_id'] == $_SESSION['user_id']) {
                                        $show_status = true;
                                    }
                                }

                                if ($show_status) {
                                    if ($row['status'] == 1) echo '<span class="badge bg-success mb-2">✓ Đã duyệt</span>';
                                    elseif ($row['status'] == 0) echo '<span class="badge bg-warning mb-2">⏳ Chờ duyệt</span>';
                                    elseif ($row['status'] == -1) echo '<span class="badge bg-danger mb-2">✗ Bị từ chối</span>';
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
                                if ($user_role >= 3) {
                                    echo '<div class="d-flex gap-2 mt-2">';
                                    if ($row['status'] != 1) echo '<a href="./posts/approve_post.php?id=' . $row['id'] . '" class="btn btn-success btn-sm flex-grow-1"><i class="bi bi-check-lg me-1"></i>Duyệt</a>';
                                    if ($row['status'] != -1) echo '<a href="./posts/reject_post.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm flex-grow-1"><i class="bi bi-x-lg me-1"></i>Từ chối</a>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<div class="col-12 text-center text-white">
                        <h3><i class="bi bi-search"></i></h3>
                        <p>Không tìm thấy bài viết nào phù hợp.</p>
                      </div>';
            }
            ?>
        </div>

        <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                    <?php
                    $url_params = "";
                    if (isset($_GET['type'])) $url_params .= "&type=" . urlencode($_GET['type']);
                    if (isset($_GET['search'])) $url_params .= "&search=" . urlencode($_GET['search']);
                    ?>

                    <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?><?php echo $url_params; ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?><?php echo $url_params; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?><?php echo $url_params; ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>

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
                    <p class="text-muted">Nền tảng mạng xã hội giáo dục hàng đầu.</p>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Liên kết nhanh</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php"><i class="bi bi-chevron-right small me-2"></i>Trang chủ</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-12">
                    <h5 class="fw-bold mb-3">Liên hệ hỗ trợ</h5>
                    <p class="text-muted mb-2"><i class="bi bi-envelope-fill text-primary me-2"></i> contact@qqeducation.com</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start text-muted">&copy; 2026 <strong>QQ Education</strong>.</div>
                <div class="col-md-6 text-center text-md-end text-muted">Designed by Quan & Quoc</div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>