<?php
require_once __DIR__ . '/session_manager.php';
include "header.php";

if (!isLoggedIn()) {
    echo "<script>alert('Vui lòng đăng nhập!');window.location.href='login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<script>window.history.back();</script>";
    exit;
}

$article_id = isset($_POST['article_id']) ? (int)$_POST['article_id'] : 0;
$content = $conn->real_escape_string($_POST['content'] ?? '');
$user_id = (int)$_SESSION['user_id'];

if ($article_id <= 0 || empty($content)) {
    echo "<script>alert('❌ Dữ liệu không hợp lệ!');window.history.back();</script>";
    exit;
}

// Kiểm tra bài viết có tồn tại
$check = $conn->query("SELECT article_id FROM article WHERE article_id=$article_id");
if (!$check || $check->num_rows == 0) {
    echo "<script>alert('❌ Bài viết không tồn tại!');window.history.back();</script>";
    exit;
}

$sql = "INSERT INTO comment(article_id, user_id, content, status) 
        VALUES($article_id, $user_id, '$content', 'pending')";

if ($conn->query($sql)) {
    echo "<script>alert('✓ Bình luận đã gửi! Chờ admin duyệt.');window.location.href='article.php?id=$article_id';</script>";
} else {
    echo "<script>alert('❌ Lỗi: ".$conn->error."');window.history.back();</script>";
}
exit;
?>
