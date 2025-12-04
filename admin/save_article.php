<?php
require_once __DIR__ . "/../session_manager.php";
include "../header.php";

if (!isAdmin()) {
    die("❌ Không có quyền!");
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: add_article.php");
    exit;
}

$title = $conn->real_escape_string($_POST['title'] ?? '');
$content = $conn->real_escape_string($_POST['content'] ?? '');
$cat = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
$author = (int)$_SESSION['user_id'];

if (empty($title) || empty($content)) {
    echo "<script>alert('❌ Tiêu đề và nội dung không được trống!');window.history.back();</script>";
    exit;
}

$cat_value = ($cat > 0) ? $cat : "NULL";
$sql = "INSERT INTO article(title, content, author_id, category_id, created_at) 
        VALUES('$title', '$content', $author, $cat_value, NOW())";

if ($conn->query($sql)) {
    header("Location: dashboard.php?success=1");
} else {
    echo "<script>alert('❌ Lỗi: ".$conn->error."');window.history.back();</script>";
}
exit;
?>
