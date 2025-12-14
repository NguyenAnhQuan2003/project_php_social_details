<?php
session_start();
require '../config.php';

// 1. Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$message = "";
$error = "";

// 2. XỬ LÝ KHI SUBMIT FORM
// 2. XỬ LÝ KHI SUBMIT FORM
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- KIỂM TRA LỖI POST_MAX_SIZE ---
    // Nếu $_POST rỗng nhưng trình duyệt có gửi dữ liệu (CONTENT_LENGTH > 0)
    // Chứng tỏ file quá lớn đã làm sập dữ liệu POST
    if (empty($_POST) && $_SERVER['CONTENT_LENGTH'] > 0) {
        $error = "Lỗi: File video quá lớn so với cấu hình server (post_max_size). Vui lòng kiểm tra php.ini";
    } else {
        // --- NẾU KHÔNG BỊ LỖI TRÊN THÌ MỚI LẤY DỮ LIỆU ---
        $title      = isset($_POST['title']) ? trim($_POST['title']) : '';
        $content    = isset($_POST['content']) ? trim($_POST['content']) : '';
        $type       = isset($_POST['type']) ? $_POST['type'] : 'text';
        $status     = 0; // Mặc định chưa được duyệt
        $user_id    = $_SESSION['user_id'];

        $video_filename = NULL;

        // Validate cơ bản
        if (empty($title) || empty($content)) {
            $error = "Vui lòng nhập tiêu đề và nội dung!";
        } else {
            // ... (Phần code xử lý logic bên trong giữ nguyên như cũ) ...

            // TRƯỜNG HỢP 1: NẾU LÀ BÀI VIẾT VĂN BẢN (TEXT)
            if ($type == 'text') {
                $video_filename = NULL;
            }
            // TRƯỜNG HỢP 2: NẾU LÀ VIDEO
            elseif ($type == 'video') {
                if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] == 0) {
                    // ... (Code upload giữ nguyên) ...
                    $allowed = ['mp4', 'avi', 'mov', 'mkv', 'webm'];
                    $filename = $_FILES['video_file']['name'];
                    $file_tmp = $_FILES['video_file']['tmp_name'];
                    $file_size = $_FILES['video_file']['size'];
                    $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                    if (!in_array($file_ext, $allowed)) {
                        $error = "Lỗi: Chỉ chấp nhận file video (MP4, AVI, MOV)!";
                    } elseif ($file_size > 500 * 1024 * 1024) {
                        $error = "Lỗi: File quá lớn! Vui lòng kiểm tra cấu hình PHP.";
                    } else {
                        $new_name = "vid_" . time() . "_" . rand(1000, 9999) . "." . $file_ext;
                        $upload_dir = "../uploads/";

                        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

                        if (move_uploaded_file($file_tmp, $upload_dir . $new_name)) {
                            $video_filename = $new_name;
                        } else {
                            $error = "Lỗi: Không thể lưu file lên server (Check quyền write/chmod).";
                        }
                    }
                } else {
                    // Nếu lỗi là do file quá lớn (upload_max_filesize)
                    if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] == 1) {
                        $error = "Lỗi: File vượt quá giới hạn upload_max_filesize trong php.ini";
                    } else {
                        $error = "Bạn đã chọn loại nội dung là VIDEO, vui lòng tải file lên!";
                    }
                }
            }

            // --- LƯU VÀO DATABASE ---
            if (empty($error)) {
                $sql = "INSERT INTO posts (user_id, title, content, type, video_url, status, created_at, updated_at) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("issssi", $user_id, $title, $content, $type, $video_filename, $status);
                    if ($stmt->execute()) {
                        header("Location: ../index.php");
                        exit();
                    } else {
                        $error = "Lỗi SQL: " . $conn->error;
                    }
                    $stmt->close();
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Bài Mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            padding-top: 50px;
        }

        .post-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="post-card">
                    <h2 class="text-center mb-4 text-primary fw-bold">Viết Bài Mới</h2>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tiêu đề</label>
                            <input type="text" name="title" class="form-control" required placeholder="Nhập tiêu đề...">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Loại nội dung</label>
                                <select name="type" class="form-select">
                                    <option value="text">📝 Bài viết văn bản</option>
                                    <option value="video">🎥 Video tải lên</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Trạng thái</label>
                                <select name="status" class="form-select">
                                    <option value="1">Công khai</option>
                                    <option value="0">Nháp</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Chọn Video (Nếu có)</label>
                            <input type="file" name="video_file" class="form-control" accept="video/*">
                            <div class="form-text text-danger">
                                * Lưu ý: Nếu bạn chọn "Loại nội dung" là <b>Bài viết văn bản</b>, file video ở đây sẽ bị BỎ QUA.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Nội dung</label>
                            <textarea name="content" class="form-control" rows="5" required placeholder="Nội dung bài viết..."></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="../index.php" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Đăng Bài</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>