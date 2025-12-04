<?php
$page_title = "Thêm bài viết";
include "../header.php";

if (!isAdmin()) {
    echo "<div class='container'><div class='alert alert-error'>❌ Bạn không có quyền!</div></div>";
    include "../footer.php";
    exit;
}
?>

<div class="container">
    <div class="form-container">
        <h2>Thêm bài viết</h2>

        <form method="POST" action="save_article.php">
            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="content">Nội dung</label>
                <textarea id="content" name="content" required minlength="10"></textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Danh mục</label>
                <select id="category_id" name="category_id">
                    <option value="0">-- Không phân loại --</option>
                    <?php
                    $cats = $conn->query("SELECT * FROM category ORDER BY name");
                    if ($cats && $cats->num_rows > 0) {
                        while ($c = $cats->fetch_assoc()) {
                            echo "<option value='".(int)$c['category_id']."'>".htmlspecialchars($c['name'])."</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Đăng bài</button>
                <a href="dashboard.php" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<?php include "../footer.php"; ?>
