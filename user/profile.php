<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao diện Cài đặt - QQ Social</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding-bottom: 50px;
        }

        /* --- Navbar giả lập --- */
        .navbar-dummy {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 10px 0;
            margin-bottom: 30px;
        }

        /* --- Menu bên trái --- */
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

        /* --- Nội dung bên phải --- */
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

        .table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #eee;
        }
    </style>
</head>

<body>

    <div class="navbar-dummy">
        <div class="container d-flex justify-content-between align-items-center">
            <span class="fw-bold fs-4 text-primary">QQ Social</span>

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
                        <img src="https://ui-avatars.com/api/?name=Nguyen+Quan&background=random" alt="Avatar" class="user-avatar">
                        <h5 class="fw-bold mb-1">Nguyễn Anh Quân</h5>
                        <small class="text-muted">Admin System</small>
                    </div>

                    <div class="list-group list-group-flush" id="myTab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="user-tab" data-bs-toggle="list" href="#user-settings" role="tab">
                            <i class="bi bi-person-gear me-3"></i>Cài đặt User
                        </a>
                        <a class="list-group-item list-group-item-action" id="role-tab" data-bs-toggle="list" href="#role-settings" role="tab">
                            <i class="bi bi-shield-lock me-3"></i>Cài đặt Quyền (Role)
                        </a>
                        <a class="list-group-item list-group-item-action" id="noti-tab" data-bs-toggle="list" href="#noti-settings" role="tab">
                            <i class="bi bi-bell me-3"></i>Thông báo
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="settings-card p-4 h-100">
                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="user-settings" role="tabpanel">
                            <div class="content-header">
                                <h3>Thông tin tài khoản</h3>
                                <p class="text-muted small">Quản lý thông tin cá nhân và đăng nhập.</p>
                            </div>

                            <form>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Tên đăng nhập (Username)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" value="NguyenAnhQuan2003">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email liên hệ</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                            <input type="email" class="form-control" value="quan@example.com">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Vai trò (Role Info)</label>
                                    <div class="alert alert-info d-flex align-items-center" role="alert">
                                        <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                                        <div>
                                            Bạn đang giữ quyền: <strong>Administrator</strong> (Role ID: 99)<br>
                                            <small>Role Level: 10 - Toàn quyền quản trị hệ thống.</small>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">
                                <div class="d-flex justify-content-end">

                                    <a href="../index.php" class="btn btn-light me-2 text-decoration-none">Hủy bỏ</a>

                                    <button type="button" class="btn btn-primary px-4 fw-bold">Lưu thay đổi</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="role-settings" role="tabpanel">
                            <div class="content-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h3>Cấu hình Phân quyền</h3>
                                    <p class="text-muted small">Danh sách các nhóm quyền trong hệ thống.</p>
                                </div>
                                <button class="btn btn-success btn-sm fw-bold">
                                    <i class="bi bi-plus-lg"></i> Thêm Quyền Mới
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="20%">Tên Quyền</th>
                                            <th width="10%">Level</th>
                                            <th width="45%">Mô tả</th>
                                            <th width="20%" class="text-center">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><span class="badge bg-primary">Admin</span></td>
                                            <td>10</td>
                                            <td>Quản trị viên cao cấp.</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-light text-primary"><i class="bi bi-pencil-square"></i></button>
                                                <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="noti-settings" role="tabpanel">
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