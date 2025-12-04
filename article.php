<?php
$page_title = "Chi tiết bài viết";
include "header.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    echo "<div class='container'><div class='alert alert-error'>❌ Bài viết không tồn tại!</div></div>";
    include "footer.php";
    exit;
}

$sql = "SELECT article.*, user.full_name, category.name AS category
        FROM article
        JOIN user ON article.author_id = user.user_id
        LEFT JOIN category ON article.category_id = category.category_id
        WHERE article.article_id = $id";

$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    echo "<div class='container'><div class='alert alert-error'>❌ Bài viết không tồn tại!</div></div>";
    include "footer.php";
    exit;
}

$article = $result->fetch_assoc();

// Cập nhật lượt xem
$conn->query("UPDATE article SET views = views + 1 WHERE article_id=$id");
?>

<div class="container">
    <article class="article-detail">
        <div class="article-header">
            <div class="article-category"><?php echo $article['category'] ? htmlspecialchars($article['category']) : 'Không phân loại'; ?></div>
            <h1><?php echo htmlspecialchars($article['title']); ?></h1>
            <div class="article-meta-detail">
                <span>📝 <?php echo htmlspecialchars($article['full_name']); ?></span>
                <span>📅 <?php echo date('d/m/Y H:i', strtotime($article['created_at'])); ?></span>
                <span>👁️ <?php echo (int)$article['views']; ?> lượt xem</span>
            </div>
        </div>

        <div class="article-content">
            <?php echo nl2br(htmlspecialchars($article['content'])); ?>
        </div>
    </article>

    <section class="comments-section">
        <h3>Bình luận 
            (<?php 
                $cc = $conn->query("SELECT COUNT(*) as cnt FROM comment WHERE article_id=$id AND status='approved'");
                $count = $cc->fetch_assoc();
                echo (int)$count['cnt'];
            ?>)
        </h3>

        <?php if (!isLoggedIn()): ?>
            <div class="alert alert-warning">
                💡 <a href="login.php" style="color: inherit; font-weight: 600;">Đăng nhập</a> để bình luận
            </div>
        <?php else: ?>
            <div class="comment-form">
                <h4>Gửi bình luận</h4>
                <form method="POST" action="comment_submit.php">
                    <input type="hidden" name="article_id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <textarea name="content" required placeholder="Nhập bình luận của bạn..." minlength="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                </form>
            </div>
        <?php endif; ?>

        <div class="comment-list">
            <?php
            $sqlC = "SELECT comment.*, user.full_name
                     FROM comment
                     JOIN user ON comment.user_id = user.user_id
                     WHERE comment.article_id = $id AND comment.status='approved'
                     ORDER BY comment.created_at DESC";

            $result_comments = $conn->query($sqlC);

            if ($result_comments && $result_comments->num_rows > 0) {
                while($c = $result_comments->fetch_assoc()) {
                    echo "<div class='comment-item'>";
                    echo "<div class='comment-author'>".htmlspecialchars($c['full_name'])."</div>";
                    echo "<div class='comment-date'>".date('d/m/Y H:i', strtotime($c['created_at']))."</div>";
                    echo "<div class='comment-text'>".htmlspecialchars($c['content'])."</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='no-data'>Chưa có bình luận nào.</p>";
            }
            ?>
        </div>
    </section>
</div>

<style>
.article-detail {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.article-header {
    margin-bottom: 2rem;
    border-bottom: 2px solid var(--border-color);
    padding-bottom: 1rem;
}

.article-meta-detail {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    margin-top: 1rem;
    color: #999;
    font-size: 0.95rem;
}

.article-content {
    line-height: 1.8;
    color: #333;
    font-size: 1.05rem;
}
</style>

<?php include "footer.php"; ?>
