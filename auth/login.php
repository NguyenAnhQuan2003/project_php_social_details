<?php
session_start();
// Đảm bảo đường dẫn file config đúng (dùng __DIR__ cho chắc chắn)
require_once '../config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_input = $_POST['username'] ?? '';
    $password_input = $_POST['password'] ?? '';

    if (empty($username_input) || empty($password_input)) {
        $error = 'Tài khoản và mật khẩu không được để trống.';
    } else {
        // Xử lý ký tự đặc biệt để tránh lỗi SQL cơ bản
        $safe_username = mysqli_real_escape_string($conn, $username_input);

        $sql = "SELECT * FROM users WHERE username = '$safe_username' OR email = '$safe_username'";
        $query = mysqli_query($conn, $sql);

        if ($query && mysqli_num_rows($query) > 0) {
            $user = mysqli_fetch_assoc($query);

            // --- [MỚI] KIỂM TRA TRẠNG THÁI STATUS ---
            if ($user['status'] == 'block') {
                $error = 'Tài khoản của bạn đã bị khóa do vi phạm quy tắc cộng đồng.';
            }
            // Nếu không bị block thì mới kiểm tra mật khẩu
            else if ($password_input === $user['password']) {

                // Lưu đầy đủ thông tin vào Session để dùng cho các trang khác
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['username']   = $user['username'];
                $_SESSION['role_id']    = $user['role_id'];    // Lưu ID quyền
                $_SESSION['role_level'] = $user['role_level']; // Lưu Level quyền
                $_SESSION['email']      = $user['email'];

                header('Location: ../index.php');
                exit();
            } else {
                $error = 'Mật khẩu không đúng.';
            }
        } else {
            $error = 'Tài khoản không tồn tại.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - QQ Education</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .login-card {
            max-width: 420px;
            width: 100%;
            background: white;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            padding: 2.5rem;
        }

        .btn-primary {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">Đăng Nhập</h3>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div><?php echo htmlspecialchars($error); ?></div>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label fw-bold">Tên đăng nhập hoặc Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Nhập username/email..." required>
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu..." required>
                </div>
            </div>
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary btn-lg fw-bold">Đăng Nhập</button>
            </div>

            <div class="text-center mt-3">
                <small class="text-muted">Chưa có tài khoản?
                    <a href="./register.php" class="text-decoration-none fw-bold">Đăng ký ngay</a>
                </small>
            </div>
            <div class="text-center mt-2">
                <a href="../index.php" class="text-decoration-none small text-secondary">
                    <i class="bi bi-arrow-left"></i> Quay về trang chủ
                </a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>