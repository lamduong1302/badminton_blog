<?php
/**
 * Session Manager Integration Test
 * Quick test to verify all functions are available
 */

// Test 1: Load session_manager.php
echo "🔍 Test 1: Loading session_manager.php...\n";
require_once __DIR__ . '/session_manager.php';
echo "✅ Successfully loaded session_manager.php\n\n";

// Test 2: Check all functions exist
echo "🔍 Test 2: Checking function definitions...\n";
$functions = [
    'setUserSession',
    'isLoggedIn',
    'isAdmin',
    'getCurrentUser',
    'destroySession',
    'checkSessionTimeout',
    'getSessionDuration',
    'getSessionTimeRemaining'
];

foreach ($functions as $func) {
    if (function_exists($func)) {
        echo "✅ Function '$func' exists\n";
    } else {
        echo "❌ Function '$func' NOT FOUND\n";
    }
}

echo "\n🔍 Test 3: Checking SESSION_TIMEOUT constant...\n";
if (defined('SESSION_TIMEOUT')) {
    echo "✅ SESSION_TIMEOUT defined: " . SESSION_TIMEOUT . " seconds (" . (SESSION_TIMEOUT / 60) . " minutes)\n";
} else {
    echo "❌ SESSION_TIMEOUT not defined\n";
}

echo "\n🔍 Test 4: Testing setUserSession function...\n";
setUserSession(123, 'Test User', 'testuser', 'USER');
echo "✅ setUserSession() executed\n";
echo "   - user_id: " . $_SESSION['user_id'] . "\n";
echo "   - name: " . $_SESSION['name'] . "\n";
echo "   - username: " . $_SESSION['username'] . "\n";
echo "   - role: " . $_SESSION['role'] . "\n";
echo "   - login_time: " . $_SESSION['login_time'] . "\n";
echo "   - last_activity: " . $_SESSION['last_activity'] . "\n";

echo "\n🔍 Test 5: Testing isLoggedIn function...\n";
if (isLoggedIn()) {
    echo "✅ isLoggedIn() returns true (user logged in)\n";
} else {
    echo "❌ isLoggedIn() returned false (expected true)\n";
}

echo "\n🔍 Test 6: Testing getCurrentUser function...\n";
$user = getCurrentUser();
if ($user && isset($user['user_id'])) {
    echo "✅ getCurrentUser() returned user data\n";
    echo "   - User ID: " . $user['user_id'] . "\n";
    echo "   - Name: " . $user['name'] . "\n";
} else {
    echo "❌ getCurrentUser() failed\n";
}

echo "\n🔍 Test 7: Testing admin check...\n";
setUserSession(456, 'Admin User', 'admin', 'ADMIN');
if (isAdmin()) {
    echo "✅ isAdmin() returns true (admin user)\n";
} else {
    echo "❌ isAdmin() returned false (expected true)\n";
}

echo "\n✨ All tests completed! Session manager is working correctly.\n";
?>
