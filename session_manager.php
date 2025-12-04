<?php
/**
 * Session Manager - Quản lý thông tin người dùng trong SESSION
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cấu hình session timeout (30 phút)
define('SESSION_TIMEOUT', 30 * 60);

/**
 * Khởi tạo session cho user đã đăng nhập
 */
function setUserSession($user_id, $full_name, $username, $role = 'USER') {
    $_SESSION['user_id'] = (int)$user_id;
    $_SESSION['name'] = $full_name;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;
    $_SESSION['last_activity'] = time();
    $_SESSION['login_time'] = time();
}

/**
 * Kiểm tra user đã đăng nhập
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Kiểm tra user là ADMIN
 */
function isAdmin() {
    return isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'ADMIN';
}

/**
 * Lấy thông tin user từ session
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'user_id' => $_SESSION['user_id'],
        'name' => $_SESSION['name'] ?? 'Unknown',
        'username' => $_SESSION['username'] ?? '',
        'role' => $_SESSION['role'] ?? 'USER'
    ];
}

/**
 * Kiểm tra session timeout và xóa nếu hết hạn
 */
function checkSessionTimeout() {
    if (isLoggedIn()) {
        $last_activity = $_SESSION['last_activity'] ?? time();
        
        if (time() - $last_activity > SESSION_TIMEOUT) {
            // Session hết hạn, xóa session
            destroySession();
            return false;
        }
        
        // Cập nhật thời gian hoạt động cuối cùng
        $_SESSION['last_activity'] = time();
    }
    
    return true;
}

/**
 * Hủy session (logout)
 */
function destroySession() {
    $_SESSION = [];
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    
    session_destroy();
}

/**
 * Lấy thời gian đã đăng nhập (tính bằng giây)
 */
function getSessionDuration() {
    if (!isLoggedIn()) {
        return 0;
    }
    return time() - ($_SESSION['login_time'] ?? time());
}

/**
 * Lấy thời gian còn lại của session (tính bằng giây)
 */
function getSessionTimeRemaining() {
    if (!isLoggedIn()) {
        return 0;
    }
    
    $last_activity = $_SESSION['last_activity'] ?? time();
    $remaining = SESSION_TIMEOUT - (time() - $last_activity);
    
    return max(0, $remaining);
}

// Kiểm tra session timeout ngay lập tức
checkSessionTimeout();
?>
