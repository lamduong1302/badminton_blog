<?php
$page_title = "Đăng ký";
include "header.php";

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $conn->real_escape_string($_POST['fullname'] ?? '');
    $username = $conn->real_escape_string($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Validate
    if (empty($fullname) || empty($username) || empty($password) || empty($password_confirm)) {
        $error = "❌ Vui lòng điền đầy đủ thông tin!";
    } elseif ($password !== $password_confirm) {
        $error = "❌ Mật khẩu không trùng khớp!";
    } elseif (strlen($password) < 6) {
        $error = "❌ Mật khẩu phải có ít nhất 6 ký tự!";
    } else {
        // Kiểm tra username đã tồn tại
        $check = $conn->query("SELECT id FROM user WHERE username='$username'");
        
        if ($check && $check->num_rows > 0) {
            $error = "❌ Username đã tồn tại!";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user(username, password_hash, full_name, role) 
                    VALUES('$username', '$password_hash', '$fullname', 'USER')";

            if ($conn->query($sql)) {
                $success = "✓ Đăng ký thành công! Chuyển hướng...";
                echo "<script>setTimeout(function(){ window.location.href='login.php'; }, 2000);</script>";
            } else {
                $error = "❌ Lỗi hệ thống: " . $conn->error;
            }
        }
    }
}
?>

<div class="container">
    <div class="form-container">
        <h2>Đăng ký tài khoản</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="fullname">Họ tên</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required minlength="6">
            </div>

            <div class="form-group">
                <label for="password_confirm">Xác nhận Password</label>
                <input type="password" id="password_confirm" name="password_confirm" required minlength="6">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </div>
        </form>

        <p style="text-align: center; margin-top: 1.5rem;">
            Đã có tài khoản? <a href="login.php" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Đăng nhập</a>
        </p>
    </div>
</div>

<?php include "footer.php"; ?>
