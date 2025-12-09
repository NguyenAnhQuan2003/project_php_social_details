<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Bài Viết Mới - QQ social</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        /* --- GIỮ NGUYÊN STYLE TỪ TRANG CHỦ --- */
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            margin: 0;
            color: #333;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .logo-img {
            height: 50px;
            width: auto;
        }

        .btn-primary {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
            padding: 10px 25px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* --- STYLE RIÊNG CHO TRANG TẠO POST --- */
        .form-wrapper {
            margin-top: 100px;
            /* Cách navbar */
            margin-bottom: 50px;
        }

        .post-form-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 2.5rem;
            overflow: hidden;
        }

        .form-label {
            font-weight: 600;
            color: #4a4a4a;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 0 0.25rem rgba(106, 17, 203, 0.25);
        }

        /* Animation ẩn hiện */
        #videoUrlContainer {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <img src="https://img.freepik.com/premium-vector/play-button-media-music-icon-logo-design-colorful-media-play-technology-logo-element-music-audio-streaming-service-app-video-icon-logo_144543-1677.jpg" alt="ShareHub Logo" class="logo-img">
                <span class="ms-2 fw-bold fs-4 text-dark">QQ social</span>
            </a>

            <div class="ms-auto">
                <a href="../index.php" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại Trang chủ
                </a>
            </div>
        </div>
    </nav>

    <div class="container form-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="post-form-card">
                    <h2 class="text-center fw-bold mb-4" style="color: #6a11cb;">
                        <i class="bi bi-pencil-square me-2"></i>Tạo Bài Viết Mới
                    </h2>

                    <form action="" method="POST">
                        <div class="mb-4">
                            <label for="postTitle" class="form-label">Tiêu đề bài viết <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="postTitle" name="title" placeholder="Nhập tiêu đề hấp dẫn..." required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="postType" class="form-label">Loại nội dung</label>
                                <select class="form-select" id="postType" name="type">
                                    <option value="text" selected>📝 Bài viết thường</option>
                                    <option value="video">🎥 Video Youtube</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="postStatus" class="form-label">Trạng thái</label>
                                <select class="form-select" id="postStatus" name="status">
                                    <option value="1" selected>Công khai (Public)</option>
                                    <option value="0">Nháp (Draft)</option>
                                    <option value="2">Riêng tư (Private)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4 d-none" id="videoUrlContainer">
                            <label for="videoUrl" class="form-label">Đường dẫn Video (Youtube)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-danger text-white border-danger"><i class="bi bi-youtube"></i></span>
                                <input type="url" class="form-control" id="videoUrl" name="video_url" placeholder="Ví dụ: https://www.youtube.com/watch?v=...">
                            </div>
                            <div class="form-text">Dán đường dẫn video Youtube vào đây để hiển thị player.</div>
                        </div>

                        <div class="mb-4">
                            <label for="postContent" class="form-label">Nội dung chi tiết <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="postContent" name="content" rows="6" placeholder="Bạn đang nghĩ gì?..." required></textarea>
                        </div>

                        <input type="hidden" name="user_id" value="1">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                            <button type="button" class="btn btn-light me-md-2" onclick="window.history.back()">Hủy bỏ</button>
                            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold">
                                <i class="bi bi-send-fill me-2"></i> Đăng Bài
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const postTypeSelect = document.getElementById('postType');
            const videoUrlContainer = document.getElementById('videoUrlContainer');
            const videoUrlInput = document.getElementById('videoUrl');

            // Hàm kiểm tra để ẩn hiện ô nhập URL
            function toggleVideoInput() {
                if (postTypeSelect.value === 'video') {
                    videoUrlContainer.classList.remove('d-none');
                    videoUrlInput.setAttribute('required', 'required'); // Bắt buộc nhập nếu là video
                } else {
                    videoUrlContainer.classList.add('d-none');
                    videoUrlInput.removeAttribute('required'); // Bỏ bắt buộc nếu là text
                    videoUrlInput.value = ''; // Xóa nội dung URL cũ nếu chuyển về text
                }
            }

            // Lắng nghe sự kiện thay đổi select
            postTypeSelect.addEventListener('change', toggleVideoInput);
        });
    </script>
</body>

</html>