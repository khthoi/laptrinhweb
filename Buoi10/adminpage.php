<?php
session_start();
require 'employee.php';

$db = new Database();
$employee = new Employee($db);

// Kiểm tra nếu người dùng chưa đăng nhập hoặc không phải admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Xử lý khi người dùng chọn thoát
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Gọi phương thức logout
    $employee->logout();
    // Chuyển hướng về trang đăng nhập
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị</title>
</head>
<body>
    <h1>Chào mừng quản trị viên</h1>
    
    <ul>
        <li><a href="employee_list.php">Quản trị nhân viên</a></li>
        <li><a href="user_manager.php">Quản trị người dùng</a></li>
        <li><a href="adminpage.php?action=logout">Thoát</a></li>
    </ul>
</body>
</html>
