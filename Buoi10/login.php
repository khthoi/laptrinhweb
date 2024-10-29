<?php
session_start();
require 'employee.php';

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: adminpage.php');
    } else {
        header('Location: employee_list.php');
    }
    exit();
}

$db = new Database();
$employee = new Employee();

$errors = [];

// Nếu người dùng gửi form đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Lấy dữ liệu
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate thông tin
    if (empty($username)) {
        $errors['username'] = 'Chưa nhập tên người dùng';
    }
    if (empty($password)) {
        $errors['password'] = 'Chưa nhập mật khẩu';
    }

    // Kiểm tra thông tin đăng nhập nếu không có lỗi
    if (empty($errors)) {
        if ($employee->login($username, $password)) {
            // Chuyển hướng theo vai trò đã được lưu trong session
            if ($_SESSION['role'] === 'admin') {
                header('Location: adminpage.php');
            } else if ($_SESSION['role'] === 'manager') {
                header('Location: employee_list.php');
            }
            exit();
        } else {
            $errors['login'] = 'Tên người dùng hoặc mật khẩu không đúng.';
        }
    }
}

// Ngắt kết nối
$db->disconnect($db);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>

<body>
    <h1>Đăng nhập</h1>
    <form method="post" action="">
        <table>
            <tr>
                <td>Tên người dùng</td>
                <td>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" />
                    <?php if (!empty($errors['username'])) echo '<span style="color:red;">' . htmlspecialchars($errors['username']) . '</span>'; ?>
                </td>
            </tr>
            <tr>
                <td>Mật khẩu</td>
                <td>
                    <input type="password" name="password" />
                    <?php if (!empty($errors['password'])) echo '<span style="color:red;">' . htmlspecialchars($errors['password']) . '</span>'; ?>
                </td>
            </tr>
            <?php if (!empty($errors['login'])) { ?>
                <tr>
                    <td colspan="2" style="color:red;"><?php echo htmlspecialchars($errors['login']); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="login" value="Đăng nhập" />
                </td>
            </tr>
            <tr>
                <td>Tài Khoản</td>
                <td>
                    <p>User_name: admin</p>
                    <p>Password: admin123</p>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>