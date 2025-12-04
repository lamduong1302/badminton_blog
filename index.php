<?php
$page_title = "Cầu Lông Blog";
include "header.php";
?>

<div class="container">
    <section class="hero">
        <h2>Chia sẻ kinh nghiệm cầu lông</h2>
        <p>Khám phá những bài viết hữu ích từ cộng đồng yêu thích cầu lông</p>
    </section>

    <!-- Search -->
    <section class="search-section" style="margin:1.5rem 0;">
        <form method="GET" action="index.php" class="search-form" style="display:flex;gap:0.5rem;flex-wrap:wrap;align-items:center;">
            <?php
            // load categories for filter
            $cats = $conn->query("SELECT category_id, name FROM category ORDER BY name");
            $q = isset($_GET['q']) ? $conn->real_escape_string(trim($_GET['q'])) : '';
            $catFilter = isset($_GET['category']) ? (int)$_GET['category'] : 0;
            ?>
            <input type="search" name="q" placeholder="Tìm theo tiêu đề" value="<?php echo htmlspecialchars($q); ?>" style="flex:1;min-width:200px;padding:0.6rem;border-radius:4px;border:1px solid var(--border-color);">
            <select name="category" style="padding:0.6rem;border-radius:4px;border:1px solid var(--border-color);">
                <option value="0">-- Tất cả chuyên mục --</option>
                <?php if ($cats) while($cc = $cats->fetch_assoc()): ?>
                    <option value="<?php echo (int)$cc['category_id']; ?>" <?php echo $catFilter== (int)$cc['category_id']? 'selected':''; ?>><?php echo htmlspecialchars($cc['name']); ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            <?php if ($q !== '' || $catFilter>0): ?>
                <a href="index.php" class="btn btn-secondary" style="text-decoration:none;display:inline-block;padding:0.6rem 0.9rem;border-radius:4px;">Xóa</a>
            <?php endif; ?>
        </form>
    </section>

    <section class="articles">
        <h3 class="section-title">Bài viết mới nhất</h3>
        <div class="articles-grid">
            <?php
            // Build base query and apply filters from search form
            $where = [];
            if ($q !== '') {
                $like = '%' . $conn->real_escape_string($q) . '%';
                $where[] = "article.title LIKE '" . $like . "'";
            }
            if ($catFilter > 0) {
                $where[] = "article.category_id = " . $catFilter;
            }

            $sql = "SELECT article.*, user.full_name, category.name AS category
                    FROM article
                    JOIN user ON article.author_id = user.user_id
                    LEFT JOIN category ON article.category_id = category.category_id";

            if (count($where) > 0) {
                $sql .= " WHERE " . implode(' AND ', $where);
            }

            $sql .= " ORDER BY article.created_at DESC";

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cat = $row['category'] ? htmlspecialchars($row['category']) : 'Không phân loại';
                    $title = htmlspecialchars($row['title']);
                    $author = htmlspecialchars($row['full_name']);
                    $date = date('d/m/Y', strtotime($row['created_at']));
                    $excerpt = htmlspecialchars(mb_substr($row['content'], 0, 150)) . '...';
                    $id = (int)$row['article_id'];
                    
                    echo "<article class='article-card'>";
                    echo "<div class='article-category'>$cat</div>";
                    echo "<h4 class='article-title'>$title</h4>";
                    echo "<p class='article-meta'>📝 Bởi <strong>$author</strong> | 📅 $date</p>";
                    echo "<p class='article-excerpt'>$excerpt</p>";
                    echo "<a href='article.php?id=$id' class='read-more'>Xem chi tiết →</a>";
                    echo "</article>";
                }
            } else {
                echo "<p class='no-articles'>Không tìm thấy kết quả phù hợp.</p>";
            }
            ?>
        </div>
    </section>
</div>

<?php include "footer.php"; ?>

