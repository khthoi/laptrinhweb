<?php
session_start();
require 'employee.php';

// Kiểm tra nếu người dùng không phải admin thì chuyển hướng về trang khác
if ($_SESSION['role'] !== 'admin') {
    header('Location: employee_list.php');
    exit();
}

$db = new Database();
$employee = new Employee($db);

// Lấy danh sách người dùng
$users = $employee->getAllUser();

// Ngắt kết nối
$db->disconnect($db);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <style>
        table {
            width: 100%; /* Làm cho bảng rộng 100% */
            border-collapse: collapse; /* Gộp các viền lại */
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd; /* Thêm viền cho bảng */
        }
        th {
            background-color: #f2f2f2; /* Màu nền cho tiêu đề bảng */
        }
    </style>
</head>
<body>
    <h1>Quản lý người dùng</h1>
    <a href="register.php">Thêm người dùng</a><br/><br/>
    <a href="adminpage.php">Trở về trang quản trị</a><br/><br/>

    <table>
        <tr>
            <th>User ID</th>
            <th>Tên đăng nhập</th>
            <th>Mật khẩu (Hash)</th>
            <th>Vai trò</th>
        </tr>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo htmlspecialchars($user['UserID']); ?></td>
                <td><?php echo htmlspecialchars($user['Username']); ?></td>
                <td><?php echo htmlspecialchars($user['PasswordHash']); ?></td>
                <td><?php echo htmlspecialchars($user['Role']); ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
