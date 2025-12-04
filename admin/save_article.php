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

// If article_id provided -> update mode
$article_id = isset($_POST['article_id']) ? (int)$_POST['article_id'] : 0;

if (empty($title) || empty($content)) {
    echo "<script>alert('❌ Tiêu đề và nội dung không được trống!');window.history.back();</script>";
    exit;
}

$cat_value = ($cat > 0) ? $cat : "NULL";

if ($article_id > 0) {
    // Update existing article
    $sql = "UPDATE article SET title='$title', content='$content', category_id=$cat_value, updated_at=NOW() WHERE article_id=" . $article_id;
    if ($conn->query($sql)) {
        header("Location: dashboard.php?updated=1");
    } else {
        echo "<script>alert('❌ Lỗi: ".$conn->error."');window.history.back();</script>";
    }
} else {
    // Insert new article
    $sql = "INSERT INTO article(title, content, author_id, category_id, created_at) 
            VALUES('$title', '$content', $author, $cat_value, NOW())";

    if ($conn->query($sql)) {
        header("Location: dashboard.php?success=1");
    } else {
        echo "<script>alert('❌ Lỗi: ".$conn->error."');window.history.back();</script>";
    }
}
exit;
?>
