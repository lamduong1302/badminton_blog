<?php
require_once __DIR__ . "/../session_manager.php";
include "../header.php";

if (!isAdmin()) {
    die("❌ Bạn không có quyền!");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: dashboard.php");
    exit;
}

$article_id = isset($_POST['article_id']) ? (int)$_POST['article_id'] : 0;
if ($article_id <= 0) {
    header("Location: dashboard.php?error=1");
    exit;
}

// Delete related comments first (optional)
$conn->query("DELETE FROM comment WHERE article_id=" . $article_id);

// Delete the article
if ($conn->query("DELETE FROM article WHERE article_id=" . $article_id)) {
    header("Location: dashboard.php?deleted=1");
} else {
    header("Location: dashboard.php?error=" . urlencode($conn->error));
}
exit;

?>
