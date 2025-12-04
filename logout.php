<?php
require_once __DIR__ . '/session_manager.php';

// Use centralized session destruction
destroySession();

header("Location: index.php");
exit;
?>
