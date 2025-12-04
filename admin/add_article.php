<?php
$page_title = "Thêm bài viết";
include "../header.php";

if (!isAdmin()) {
    echo "<div class='container'><div class='alert alert-error'>❌ Bạn không có quyền!</div></div>";
    include "../footer.php";
    exit;
}

// Edit mode: load article if editing
$edit_id = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$edit_article = null;
if ($edit_id > 0) {
    $res = $conn->query("SELECT * FROM article WHERE article_id=" . $edit_id);
    if ($res && $res->num_rows > 0) {
        $edit_article = $res->fetch_assoc();
    } else {
        $edit_id = 0; // reset if not found
    }
}
?>

<div class="container">
    <div class="form-container">
        <h2><?php echo $edit_article ? 'Chỉnh sửa bài viết' : 'Thêm bài viết'; ?></h2>

        <form method="POST" action="save_article.php">
            <?php if ($edit_article): ?>
                <input type="hidden" name="article_id" value="<?php echo (int)$edit_article['article_id']; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" id="title" name="title" required value="<?php echo $edit_article ? htmlspecialchars($edit_article['title']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="content">Nội dung</label>
                <textarea id="content" name="content" required minlength="10"><?php echo $edit_article ? htmlspecialchars($edit_article['content']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Danh mục</label>
                <select id="category_id" name="category_id">
                    <option value="0">-- Không phân loại --</option>
                    <?php
                    $cats = $conn->query("SELECT * FROM category ORDER BY name");
                    if ($cats && $cats->num_rows > 0) {
                        while ($c = $cats->fetch_assoc()) {
                            $sel = ($edit_article && (int)$edit_article['category_id'] === (int)$c['category_id']) ? ' selected' : '';
                            echo "<option value='".(int)$c['category_id']."'{$sel}>".htmlspecialchars($c['name'])."</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><?php echo $edit_article ? 'Cập nhật' : 'Đăng bài'; ?></button>
                <a href="dashboard.php" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<?php include "../footer.php"; ?>
