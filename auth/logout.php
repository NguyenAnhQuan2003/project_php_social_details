<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạm biệt - Hẹn gặp lại!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        .logout-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
            animation: fadeIn 0.8s ease-out;
        }

        .cute-img {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
        }

        h2 {
            color: #333;
            font-weight: bold;
            margin-bottom: 10px;
        }

        p {
            color: #666;
            margin-bottom: 20px;
        }

        .spinner-border {
            width: 1.5rem;
            height: 1.5rem;
            color: #6a11cb;
        }

        .btn-home {
            background-color: #f0f2f5;
            color: #333;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-home:hover {
            background-color: #e4e6eb;
            transform: translateY(-2px);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="logout-card">
        <img src="https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExM3R6eWwxZnZ4OGx4Z3I2Z3I2Z3I2Z3I2Z3I2Z3I2Z3I2/STcH48x341Q8Q/giphy.gif"
            alt="Goodbye Cat" class="cute-img">

        <h2>Tạm biệt nhé! 👋</h2>
        <p>Bạn đã đăng xuất thành công.<br>Hẹn sớm gặp lại bạn tại QQ Social.</p>

        <div class="mt-4">
            <p class="small text-muted mb-2">
                <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                Đang quay về trang chủ sau <span id="countdown">3</span>s...
            </p>
            <a href="../index.php" class="btn btn-home text-decoration-none">
                Về trang chủ ngay
            </a>
        </div>
    </div>

    <script>
        // Logic đếm ngược và chuyển hướng
        let seconds = 3;
        const countdownEl = document.getElementById('countdown');

        const timer = setInterval(() => {
            seconds--;
            countdownEl.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(timer);
                // Chuyển hướng về trang chủ (hoặc login.php tùy bạn)
                window.location.href = '../index.php';
            }
        }, 1000);
    </script>

</body>

</html>