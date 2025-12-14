<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
}

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password     = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id          = $_SESSION['user_id'];

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } elseif ($new_password != $confirm_password) {
        $error = "Mật khẩu mới nhập lại không khớp!";
    } else {
        $sql = "SELECT password FROM users WHERE id = $user_id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row['password'] == $current_password) {
                $update_sql = "UPDATE users SET password = '$new_password' WHERE id = $user_id";

                if ($conn->query($update_sql) === TRUE) {
                    $message = "Đổi mật khẩu thành công!";
                } else {
                    $error = "Lỗi SQL Update: " . $conn->error;
                }
            } else {
                $error = "Mật khẩu hiện tại không đúng!";
            }
        } else {
            $error = "Không tìm thấy tài khoản người dùng.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi Mật Khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            width: 100%;
            max-width: 450px;
        }
    </style>
</head>

<body>

    <div class="password-card">
        <h3 class="text-center fw-bold mb-4 text-primary">Đổi Mật Khẩu</h3>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success text-center"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Mật khẩu hiện tại</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Mật khẩu mới</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Xác nhận mật khẩu mới</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary fw-bold">Lưu Thay Đổi</button>
                <a href="../index.php" class="btn btn-outline-secondary">Quay lại</a>
            </div>
        </form>
    </div>

</body>

</html>