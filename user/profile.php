<?php
session_start();
require '../config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";
$error = "";
$active_tab = 'user-settings';

// --- 0.1 XỬ LÝ: CHẶN/BỎ CHẶN NGƯỜI DÙNG ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'toggle_status') {
    $target_user_id = intval($_POST['user_id'] ?? 0);

    if ($target_user_id > 0) {
        $sql_check = "SELECT status FROM users WHERE id = '$target_user_id'";
        $result_check = mysqli_query($conn, $sql_check);
        $target_user = mysqli_fetch_assoc($result_check);

        if ($target_user) {
            $new_status = ($target_user['status'] == 'active') ? 'block' : 'active';
            $sql_update_status = "UPDATE users SET status = '$new_status' WHERE id = '$target_user_id'";

            if (mysqli_query($conn, $sql_update_status)) {
                $action_text = ($new_status == 'block') ? 'chặn' : 'bỏ chặn';
                $_SESSION['toggle_message'] = "Đã $action_text người dùng thành công!";
                header("Location: profile.php?tab=role-settings");
                exit();
            }
        }
    }
}

// --- 0.2 [CẬP NHẬT] XỬ LÝ: SỬA ROLE LEVEL ---
// Sửa logic: Nhận role_level thay vì role_id
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update_user_role') {
    $target_user_id = intval($_POST['user_id'] ?? 0);
    $new_role_level = intval($_POST['new_role_level'] ?? 0); // Đổi tên biến

    // Kiểm tra cơ bản
    if ($target_user_id > 0 && $new_role_level > 0 && $target_user_id != $user_id) {
        // Cập nhật trường role_level
        $sql_update_role = "UPDATE users SET role_level = '$new_role_level' WHERE id = '$target_user_id'";

        if (mysqli_query($conn, $sql_update_role)) {
            $_SESSION['toggle_message'] = "Đã cập nhật cấp độ quyền (Level) thành công!";
            header("Location: profile.php?tab=role-settings");
            exit();
        } else {
            $_SESSION['toggle_error'] = "Lỗi SQL: " . mysqli_error($conn);
        }
    }
}

// Kiểm tra parameter tab từ URL
if (isset($_GET['tab'])) {
    $active_tab = $_GET['tab'];
}

// Xử lý thông báo session
if (isset($_SESSION['toggle_message'])) {
    $message = $_SESSION['toggle_message'];
    unset($_SESSION['toggle_message']);
}
if (isset($_SESSION['toggle_error'])) {
    $error = $_SESSION['toggle_error'];
    unset($_SESSION['toggle_error']);
}

// --- 1. XỬ LÝ POST (CẬP NHẬT PROFILE CÁ NHÂN) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['action'])) {
    $username_new = $_POST['username'] ?? '';
    $email_new    = $_POST['email'] ?? '';

    if (empty($username_new) || empty($email_new)) {
        $error = "Vui lòng không để trống thông tin!";
    } else {
        $sql_update = "UPDATE users SET username = '$username_new', email = '$email_new' WHERE id = '$user_id'";
        if (mysqli_query($conn, $sql_update)) {
            $message = "Cập nhật thành công!";
            $_SESSION['username'] = $username_new;
            $active_tab = 'user-settings';
        } else {
            $error = "Lỗi SQL: " . mysqli_error($conn);
        }
    }
}

// --- 2. LẤY DỮ LIỆU USER HIỆN TẠI ---
$sql_get = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql_get);
$user = mysqli_fetch_assoc($result);

if ($user) {
    $_SESSION['role_id']    = $user['role_id'];
    $_SESSION['role_level'] = $user['role_level']; // Quan trọng
    $_SESSION['email']      = $user['email'];
}

// --- 3. LẤY DANH SÁCH ROLE ---
$sql_roles = "SELECT id, role_name, role_level, description FROM roles ORDER BY role_level ASC";
$result_roles = mysqli_query($conn, $sql_roles);
$roles = mysqli_fetch_all($result_roles, MYSQLI_ASSOC);

// Lấy tên role hiện tại để hiển thị
$current_role_name = "";
foreach ($roles as $role) {
    // So sánh theo role_level để tìm tên hiển thị cho chính xác
    if ($role['role_level'] == $user['role_level']) {
        $current_role_name = $role['role_name'];
        break;
    }
}

// --- 4. LẤY DANH SÁCH USERS ---
$users_list = [];
// Logic hiển thị user dựa trên Role ID (Bạn có thể sửa thành Role Level nếu muốn: $user['role_level'] >= 10)
if ($user['role_level'] == 4) {
    // Lấy thêm trường role_level
    $sql_users = "SELECT id, username, email, role_id, role_level, status FROM users WHERE id != '$user_id' ORDER BY username ASC";
} elseif ($user['role_level'] == 3) {
    $sql_users = "SELECT id, username, email, role_id, role_level, status FROM users WHERE role_level != 4 AND id != '$user_id' ORDER BY username ASC";
} else {
    $sql_users = "SELECT id, username, email, role_id, role_level, status FROM users WHERE 1=0";
}
$result_users = mysqli_query($conn, $sql_users);
if ($result_users) {
    $users_list = mysqli_fetch_all($result_users, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cài đặt tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding-bottom: 50px;
        }

        .navbar-dummy {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 10px 0;
            margin-bottom: 30px;
        }

        .settings-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: none;
        }

        .avatar-section {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid #e7f3ff;
        }

        .list-group-flush .list-group-item {
            border: none;
            padding: 15px 20px;
            font-weight: 500;
            color: #65676b;
            transition: all 0.2s;
            cursor: pointer;
            border-left: 3px solid transparent;
        }

        .list-group-flush .list-group-item:hover {
            background-color: #f2f2f2;
            color: #050505;
        }

        .list-group-flush .list-group-item.active {
            background-color: #e7f3ff;
            color: #1877f2;
            border-color: #1877f2;
            border-left: 3px solid #1877f2;
        }

        .list-group-flush .list-group-item.active i {
            color: #1877f2;
        }

        .content-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .content-header h3 {
            font-weight: 700;
            color: #1c1e21;
            margin: 0;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #65676b;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #1877f2;
        }
    </style>
</head>

<body>
    <div class="navbar-dummy">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="../index.php" class="d-flex align-items-center mb-3 text-decoration-none">
                <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(106, 17, 203, 0.3);">
                    <span style="color: white; font-weight: 900; font-family: sans-serif; font-size: 20px; letter-spacing: -1px;">QQ</span>
                </div>
                <span class="fs-4 fw-bold text-primary ms-2">Education</span>
            </a>
            <a href="../index.php" class="btn btn-outline-secondary btn-sm rounded-pill px-3 text-decoration-none">
                <i class="bi bi-arrow-left"></i> Về trang chủ
            </a>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="settings-card">
                    <div class="avatar-section">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['username']); ?>&background=random" alt="Avatar" class="user-avatar">
                        <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($user['username']); ?></h5>
                        <small class="text-muted"><?php echo htmlspecialchars($user['email']); ?></small>
                    </div>

                    <div class="list-group list-group-flush" id="myTab" role="tablist">
                        <a class="list-group-item list-group-item-action <?php echo ($active_tab == 'user-settings') ? 'active' : ''; ?>" id="user-tab" data-bs-toggle="list" href="#user-settings" role="tab">
                            <i class="bi bi-person-gear me-3"></i>Cài đặt User
                        </a>
                        <?php if ($user['role_level'] == 4 || $user['role_level'] == 3): ?>
                            <a class="list-group-item list-group-item-action <?php echo ($active_tab == 'role-settings') ? 'active' : ''; ?>" id="role-tab" data-bs-toggle="list" href="#role-settings" role="tab">
                                <i class="bi bi-shield-lock me-3"></i>Cài đặt Quyền (Role)
                            </a>
                        <?php endif; ?>
                        <a class="list-group-item list-group-item-action <?php echo ($active_tab == 'noti-settings') ? 'active' : ''; ?>" id="noti-tab" data-bs-toggle="list" href="#noti-settings" role="tab">
                            <i class="bi bi-bell me-3"></i>Thông báo
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="settings-card p-4 h-100">
                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade <?php echo ($active_tab == 'user-settings') ? 'show active' : ''; ?>" id="user-settings" role="tabpanel">
                            <div class="content-header">
                                <h3>Thông tin tài khoản</h3>
                                <p class="text-muted small">Quản lý thông tin cá nhân và đăng nhập.</p>
                            </div>

                            <?php if (!empty($message)): ?>
                                <div class="alert alert-success"><?php echo $message; ?></div>
                            <?php endif; ?>

                            <?php if (!empty($error)): ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php endif; ?>

                            <form method="POST" action="">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Tên đăng nhập</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Vai trò hiện tại</label>
                                    <div class="alert alert-info d-flex align-items-center" role="alert">
                                        <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                                        <div>
                                            Bạn đang giữ Role ID: <strong><?php echo $user['role_level']; ?> (<?php echo htmlspecialchars($current_role_name); ?>)</strong><br>
                                            <small>Role Level: <?php echo $user['role_level']; ?></small>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">
                                <div class="d-flex justify-content-end">
                                    <a href="../index.php" class="btn btn-light me-2 text-decoration-none">Hủy bỏ</a>
                                    <button type="submit" class="btn btn-primary px-4 fw-bold">Lưu thay đổi</button>
                                </div>
                            </form>
                        </div>

                        <?php if ($user['role_level'] == 4 || $user['role_level'] == 3): ?>
                            <div class="tab-pane fade <?php echo ($active_tab == 'role-settings') ? 'show active' : ''; ?>" id="role-settings" role="tabpanel">

                                <div class="content-header mt-3">
                                    <h3>Quản lý Người dùng</h3>
                                    <p class="text-muted small">Danh sách các thành viên (Ẩn Admin/Mod cấp cao hơn).</p>
                                </div>

                                <?php if ($active_tab == 'role-settings' && !empty($message)): ?>
                                    <div class="alert alert-success"><?php echo $message; ?></div>
                                <?php endif; ?>

                                <?php if ($active_tab == 'role-settings' && !empty($error)): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>

                                <div class="table-responsive mb-5">
                                    <table class="table table-hover align-middle border">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">ID</th>
                                                <th width="25%">Tên Người dùng</th>
                                                <th width="30%">Email</th>
                                                <th width="25%">Phân quyền (Level)</th>
                                                <th width="15%" class="text-center">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($users_list)): ?>
                                                <?php foreach ($users_list as $list_user): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($list_user['id']); ?></td>
                                                        <td>
                                                            <strong><?php echo htmlspecialchars($list_user['username']); ?></strong>
                                                            <?php if ($list_user['status'] == 'block'): ?>
                                                                <span class="badge bg-danger ms-1">Blocked</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($list_user['email']); ?></td>

                                                        <td>
                                                            <form method="POST" class="d-flex gap-1" onsubmit="return confirm('Xác nhận thay đổi Cấp độ quyền (Level) cho <?php echo $list_user['username']; ?>?');">
                                                                <input type="hidden" name="action" value="update_user_role">
                                                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($list_user['id']); ?>">

                                                                <select name="new_role_level" class="form-select form-select-sm" style="min-width: 120px;">
                                                                    <?php foreach ($roles as $r): ?>
                                                                        <option value="<?php echo $r['role_level']; ?>" <?php echo ($r['role_level'] == $list_user['role_level']) ? 'selected' : ''; ?>>
                                                                            <?php echo htmlspecialchars($r['role_name']) . " (Lv " . $r['role_level'] . ")"; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>

                                                                <button type="submit" class="btn btn-sm btn-primary" title="Lưu Level mới">
                                                                    <i class="bi bi-floppy-fill"></i>
                                                                </button>
                                                            </form>
                                                        </td>

                                                        <td class="text-center">
                                                            <?php
                                                            $is_blocked = ($list_user['status'] == 'block');
                                                            $btn_color = $is_blocked ? 'success' : 'danger';
                                                            $btn_text = $is_blocked ? 'Bỏ chặn' : 'Chặn';
                                                            $btn_icon = $is_blocked ? 'check-circle' : 'ban';
                                                            ?>
                                                            <form method="POST" action="" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn <?php echo $btn_text; ?> người này?');">
                                                                <input type="hidden" name="action" value="toggle_status">
                                                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($list_user['id']); ?>">
                                                                <button type="submit" class="btn btn-sm btn-<?php echo $btn_color; ?> text-white" title="<?php echo $btn_text; ?>">
                                                                    <i class="bi bi-<?php echo $btn_icon; ?>"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">Không có người dùng nào để quản lý.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="content-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3>Danh sách Phân quyền</h3>
                                        <p class="text-muted small">Các cấp độ quyền hạn trong hệ thống.</p>
                                    </div>
                                    <?php if ($user['role_level'] == 4): ?>
                                        <button class="btn btn-success btn-sm fw-bold">
                                            <i class="bi bi-plus-lg"></i> Thêm Quyền
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover align-middle border">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">ID</th>
                                                <th width="20%">Tên Quyền</th>
                                                <th width="10%">Level</th>
                                                <th width="45%">Mô tả</th>
                                                <th width="20%" class="text-center">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($roles)): ?>
                                                <?php foreach ($roles as $role): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($role['id']); ?></td>
                                                        <td><span class="badge bg-primary"><?php echo htmlspecialchars($role['role_name']); ?></span></td>
                                                        <td><?php echo htmlspecialchars($role['role_level']); ?></td>
                                                        <td><?php echo htmlspecialchars($role['description']); ?></td>
                                                        <td class="text-center">
                                                            <?php if ($user['role_level'] == 4): ?>
                                                                <button class="btn btn-sm btn-light text-primary"><i class="bi bi-pencil-square"></i></button>
                                                                <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                                                            <?php else: ?>
                                                                <small class="text-muted">Xem</small>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">Không có quyền nào trong hệ thống.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        <?php endif; ?>

                        <div class="tab-pane fade <?php echo ($active_tab == 'noti-settings') ? 'show active' : ''; ?>" id="noti-settings" role="tabpanel">
                            <div class="content-header">
                                <h3>Cài đặt thông báo</h3>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="emailNoti" checked>
                                <label class="form-check-label" for="emailNoti">Gửi email khi có người bình luận</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>