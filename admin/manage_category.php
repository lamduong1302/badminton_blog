<?php
$page_title = "Quản lý danh mục";
include "../header.php";

if (!isAdmin()) {
    echo "<div class='container'><div class='alert alert-error'>❌ Bạn không có quyền!</div></div>";
    include "../footer.php";
    exit;
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM category WHERE category_id=$id");
    header("Location: manage_category.php?success=1");
    exit;
}
?>

<div class="container">
    <div class="admin-header">
        <h2>Quản lý danh mục</h2>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">✓ Thao tác thành công!</div>
    <?php endif; ?>

    <div class="form-container" style="max-width: 600px;">
        <h3>Thêm danh mục mới</h3>
        <form method="POST" action="save_category.php">
            <div class="form-group">
                <label for="name">Tên danh mục</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description"></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Thêm danh mục</button>
            </div>
        </form>
    </div>

    <h3 style="margin-top: 2rem;">Danh sách danh mục</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Tên danh mục</th>
                <th>Mô tả</th>
                <th>Bài viết</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = $conn->query("SELECT category.*, COUNT(article.article_id) AS cnt
                                FROM category
                                LEFT JOIN article ON category.category_id = article.category_id
                                GROUP BY category.category_id
                                ORDER BY category.name");
            
            if ($res && $res->num_rows > 0) {
                while ($c = $res->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".htmlspecialchars($c['name'])."</td>";
                    echo "<td>".htmlspecialchars($c['description'] ?? '')."</td>";
                    echo "<td>".(int)$c['cnt']."</td>";
                    echo "<td><a href='?delete=".(int)$c['category_id']."' class='btn btn-danger btn-small' onclick=\"return confirm('Xóa danh mục?')\">Xóa</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='no-data'>Chưa có danh mục nào</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include "../footer.php"; ?>
