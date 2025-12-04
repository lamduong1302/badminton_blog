<?php
$page_title = "Đăng nhập";
include "header.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "❌ Vui lòng điền đầy đủ thông tin!";
    } else {
        $sql = "SELECT * FROM user WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $stored = $user['password_hash'] ?? '';

            // Check password: normal hashed flow
            $password_ok = false;
            if (!empty($stored) && password_verify($password, $stored)) {
                $password_ok = true;
            }

            // Legacy: if stored value equals plaintext password (old DB), accept and re-hash
            if (!$password_ok && $password !== '' && $password === $stored) {
                // rehash and update stored password to secure hash
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $stmtVal = $conn->real_escape_string($newHash);
                $conn->query("UPDATE user SET password_hash='{$stmtVal}' WHERE user_id=" . (int)$user['user_id']);
                $password_ok = true;
            }

            if ($password_ok) {
                // Use centralized session manager to set user data
                setUserSession($user['user_id'], $user['full_name'], $username, $user['role']);

                // Redirect ADMINs to admin dashboard by default
                if (isset($user['role']) && $user['role'] === 'ADMIN') {
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            } else {
                $error = "❌ Sai mật khẩu!";
            }
        } else {
            $error = "❌ Tài khoản không tồn tại!";
        }
    }
}
?>

<div class="container">
    <div class="form-container">
        <h2>Đăng nhập</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </div>
        </form>

        <p style="text-align: center; margin-top: 1.5rem;">
            Chưa có tài khoản? <a href="register.php" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Đăng ký ngay</a>
        </p>
    </div>
</div>

<?php include "footer.php"; ?>


