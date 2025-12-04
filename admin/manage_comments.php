<?php
$page_title = "Duyệt bình luận";
include "../header.php";

if (!isAdmin()) {
    echo "<div class='container'><div class='alert alert-error'>❌ Bạn không có quyền!</div></div>";
    include "../footer.php";
    exit;
}

if (isset($_GET['approve'])) {
    $id = (int)$_GET['approve'];
    $conn->query("UPDATE comment SET status='approved' WHERE comment_id=$id");
    header("Location: manage_comments.php?success=1");
    exit;
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM comment WHERE comment_id=$id");
    header("Location: manage_comments.php?success=1");
    exit;
}
?>

<div class="container">
    <div class="admin-header">
        <h2>Duyệt bình luận</h2>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">✓ Thao tác thành công!</div>
    <?php endif; ?>

    <h3>Bình luận chờ duyệt</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Người bình luận</th>
                <th>Bài viết</th>
                <th>Nội dung</th>
                <th>Ngày gửi</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $pending = $conn->query("SELECT comment.*, user.full_name, article.title
                                    FROM comment
                                    JOIN user ON comment.user_id = user.user_id
                                    JOIN article ON comment.article_id = article.article_id
                                    WHERE comment.status='pending'
                                    ORDER BY comment.created_at DESC");

            if ($pending && $pending->num_rows > 0) {
                while($c = $pending->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".htmlspecialchars($c['full_name'])."</td>";
                    echo "<td><a href='../article.php?id=".(int)$c['article_id']."' style='color: var(--primary-color);'>".htmlspecialchars(substr($c['title'], 0, 50))."</a></td>";
                    $fullContent = htmlspecialchars($c['content'], ENT_QUOTES);
                    $excerpt = htmlspecialchars(mb_substr($c['content'], 0, 60));
                    echo "<td>$excerpt";
                    if (mb_strlen($c['content']) > 60) {
                        echo " <button class='btn btn-small btn-primary btn-view' data-content=\"$fullContent\">Xem</button>";
                    }
                    echo "</td>";
                    echo "<td>".date('d/m/Y H:i', strtotime($c['created_at']))."</td>";
                    echo "<td class='table-actions'>";
                    echo "<a href='?approve=".(int)$c['comment_id']."' class='approve'>Duyệt</a>";
                    echo "<a href='?delete=".(int)$c['comment_id']."' class='delete' onclick=\"return confirm('Xóa bình luận?')\">Xóa</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='no-data'>Không có bình luận nào chờ duyệt</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h3 style="margin-top: 2rem;">Bình luận đã duyệt</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Người bình luận</th>
                <th>Bài viết</th>
                <th>Nội dung</th>
                <th>Ngày gửi</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $approved = $conn->query("SELECT comment.*, user.full_name, article.title
                                     FROM comment
                                     JOIN user ON comment.user_id = user.user_id
                                     JOIN article ON comment.article_id = article.article_id
                                     WHERE comment.status='approved'
                                     ORDER BY comment.created_at DESC
                                     LIMIT 20");

            if ($approved && $approved->num_rows > 0) {
                while($c = $approved->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".htmlspecialchars($c['full_name'])."</td>";
                    echo "<td><a href='../article.php?id=".(int)$c['article_id']."' style='color: var(--primary-color);'>".htmlspecialchars(substr($c['title'], 0, 50))."</a></td>";
                    $fullContent = htmlspecialchars($c['content'], ENT_QUOTES);
                    $excerpt = htmlspecialchars(mb_substr($c['content'], 0, 60));
                    echo "<td>$excerpt";
                    if (mb_strlen($c['content']) > 60) {
                        echo " <button class='btn btn-small btn-primary btn-view' data-content=\"$fullContent\">Xem</button>";
                    }
                    echo "</td>";
                    echo "<td>".date('d/m/Y H:i', strtotime($c['created_at']))."</td>";
                    echo "<td class='table-actions'>";
                    echo "<a href='?delete=".(int)$c['comment_id']."' class='delete' onclick=\"return confirm('Xóa bình luận?')\">Xóa</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='no-data'>Chưa có bình luận nào</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal for viewing full comment -->
<div id="commentModal" class="modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; z-index:9999;">
    <div class="modal-inner" style="background:#fff; max-width:800px; width:90%; padding:1.25rem; border-radius:8px; box-shadow:0 10px 30px rgba(0,0,0,0.2);">
        <h3 style="margin-top:0;">Nội dung bình luận</h3>
        <div id="modalCommentBody" style="white-space:pre-wrap; color:#333; margin:0.5rem 0 1rem 0;"></div>
        <div style="text-align:right;"><button id="modalClose" class="btn btn-secondary">Đóng</button></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function showModal(content){
        var modal = document.getElementById('commentModal');
        var body = document.getElementById('modalCommentBody');
        body.textContent = content;
        modal.style.display = 'flex';
    }

    function hideModal(){
        var modal = document.getElementById('commentModal');
        modal.style.display = 'none';
    }

    // attach click handlers to view buttons
    var buttons = document.querySelectorAll('.btn-view');
    buttons.forEach(function(btn){
        btn.addEventListener('click', function(e){
            var content = btn.getAttribute('data-content') || '';
            // decode HTML entities
            var txt = document.createElement('textarea');
            txt.innerHTML = content;
            showModal(txt.value);
        });
    });

    var modalClose = document.getElementById('modalClose');
    if(modalClose) modalClose.addEventListener('click', hideModal);

    // close when clicking outside inner box
    var modal = document.getElementById('commentModal');
    if(modal) modal.addEventListener('click', function(e){
        if(e.target === modal) hideModal();
    });
});
</script>

<?php include "../footer.php"; ?>
