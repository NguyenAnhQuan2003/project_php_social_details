<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
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
            /* Thêm padding để trên mobile không bị sát mép */
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
            <h3 class="fw-bold">Đăng Nhập</h3>
        </div>

        <form action="xuly_dangnhap.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập hoặc Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập hoặc email" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Nhớ mật khẩu</label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Đăng Nhập</button>
            </div>

            <div class="text-center mt-3">
                <a href="#" class="text-decoration-none text-muted">Quên mật khẩu?</a>
            </div>

            <div class="text-center mt-3">
                <small class="text-muted">Chưa có tài khoản?
                    <a href="./register.php" class="text-decoration-none fw-bold">Đăng ký ngay</a>
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