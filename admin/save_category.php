<?php
require_once __DIR__ . "/../session_manager.php";
include "../header.php";

if (!isAdmin()) {
    die("❌ Không có quyền!");
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: manage_category.php");
    exit;
}

$name = $conn->real_escape_string($_POST['name'] ?? '');
$desc = $conn->real_escape_string($_POST['description'] ?? '');

if (empty($name)) {
    echo "<script>alert('❌ Tên danh mục không được trống!');window.history.back();</script>";
    exit;
}

$sql = "INSERT INTO category(name, description, created_at) 
        VALUES('$name', '$desc', NOW())";

if ($conn->query($sql)) {
    header("Location: manage_category.php?success=1");
} else {
    echo "<script>alert('❌ Lỗi: ".$conn->error."');window.history.back();</script>";
}
exit;
?>
