<?php
$page_title = "Trang quản trị";
include "../header.php";

if (!isAdmin()) {
    echo "<div class='container'><div class='alert alert-error'>❌ Bạn không có quyền truy cập!</div></div>";
    include "../footer.php";
    exit;
}
?>

<div class="container">
    <div class="admin-header">
        <h2>Trang quản trị</h2>
    </div>

    <div class="admin-grid">
        <?php
        $articles = $conn->query("SELECT COUNT(*) as cnt FROM article");
        $a_count = $articles->fetch_assoc();
        
        $comments = $conn->query("SELECT COUNT(*) as cnt FROM comment WHERE status='pending'");
        $c_count = $comments->fetch_assoc();
        
        $views = $conn->query("SELECT SUM(views) as cnt FROM article");
        $v_count = $views->fetch_assoc();
        ?>
        
        <div class="stat-card">
            <h3>Tổng bài viết</h3>
            <div class="stat-number"><?php echo (int)$a_count['cnt']; ?></div>
        </div>

        <div class="stat-card">
            <h3>Bình luận chờ duyệt</h3>
            <div class="stat-number"><?php echo (int)$c_count['cnt']; ?></div>
        </div>

        <div class="stat-card">
            <h3>Tổng lượt xem</h3>
            <div class="stat-number"><?php echo (int)($v_count['cnt'] ?? 0); ?></div>
        </div>
    </div>

    <div class="admin-actions">
        <a href="add_article.php" class="btn btn-primary">📝 Đăng bài viết</a>
        <a href="manage_comments.php" class="btn btn-secondary">💬 Duyệt bình luận</a>
        <a href="manage_category.php" class="btn btn-secondary">📂 Quản lý danh mục</a>
    </div>

    <section>
        <h3>Bài viết gần đây</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Tác giả</th>
                    <th>Danh mục</th>
                    <th>Lượt xem</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $articles = $conn->query("SELECT article.*, user.full_name, category.name 
                                         FROM article
                                         JOIN user ON article.author_id = user.user_id
                                         LEFT JOIN category ON article.category_id = category.category_id
                                         ORDER BY article.created_at DESC
                                         LIMIT 10");
                
                if ($articles && $articles->num_rows > 0) {
                    while ($row = $articles->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><a href='../article.php?id=".$row['article_id']."' style='color: var(--primary-color); text-decoration: none;'>".htmlspecialchars(substr($row['title'], 0, 50))."</a></td>";
                        echo "<td>".htmlspecialchars($row['full_name'])."</td>";
                        echo "<td>".($row['name'] ? htmlspecialchars($row['name']) : 'N/A')."</td>";
                        echo "<td>".(int)$row['views']."</td>";
                        echo "<td>".date('d/m/Y', strtotime($row['created_at']))."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='no-data'>Chưa có bài viết nào</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</div>

<?php include "../footer.php"; ?>
