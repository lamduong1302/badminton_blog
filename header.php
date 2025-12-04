<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Khởi tạo kết nối database nếu chưa có
if (!isset($conn)) {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "badminton_blog";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("❌ Kết nối database thất bại: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");
}

// Load centralized session manager
require_once __DIR__ . '/session_manager.php';

// Kiểm tra đường dẫn hiện tại
$is_admin_page = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
$base_path = $is_admin_page ? '../' : '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Cầu Lông Blog'; ?></title>
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <h1 class="logo">🏸 Cầu Lông Blog</h1>
                <nav class="nav-links">
                    <a href="<?php echo $base_path; ?>index.php" class="nav-link">Trang chủ</a>
                    
                    <?php if (isLoggedIn()): ?>
                        <span class="nav-user">👤 <?php echo htmlspecialchars($_SESSION['name'] ?? 'User'); ?></span>
                        <?php if (isAdmin()): ?>
                            <a href="<?php echo $is_admin_page ? 'dashboard.php' : 'admin/dashboard.php'; ?>" class="nav-link">Quản trị</a>
                        <?php endif; ?>
                        <a href="<?php echo $base_path; ?>logout.php" class="nav-link logout">Đăng xuất</a>
                    <?php else: ?>
                        <a href="<?php echo $base_path; ?>login.php" class="nav-link">Đăng nhập</a>
                        <a href="<?php echo $base_path; ?>register.php" class="nav-link btn-primary">Đăng ký</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>
    
    <main class="main-content">

