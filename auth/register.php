<?php
include "./project_cuoi_ky/config.php";

if (!$conn) {
    die('db lỗi kết nỗi!');
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Tài Khoản</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
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

        .register-card {
            max-width: 450px;
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

    <div class="register-card">
        <div class="text-center mb-4">
            <h3 class="fw-bold">Đăng Ký Tài Khoản</h3>
        </div>

        <form action="xuly_dangky.php" method="post"> <!-- Thay bằng file xử lý PHP của bạn -->
            <div class="mb-3">
                <label for="fullname" class="form-label">Họ và tên</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nhập họ và tên" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="agree" required>
                <label class="form-check-label" for="agree">
                    Tôi đồng ý với <a href="#" class="text-decoration-none">điều khoản dịch vụ</a>
                </label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Đăng Ký</button>
            </div>

            <div class="text-center mt-3">
                <small class="text-muted">Đã có tài khoản?
                    <a href="./login.php" class="text-decoration-none fw-bold">Đăng nhập ngay</a>
                </small>
            </div>
            <div class="text-center mt-3">
                <small class="text-muted">Quay trở về trang chủ?
                    <a href="../index.php" class="text-decoration-none fw-bold">Quay lại</a>
                </small>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>