<?php
session_start();
require 'employee.php';

$db = new Database();
$employee = new Employee($db);

$errors = [];

// Nếu người dùng gửi form đăng ký
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Lấy dữ liệu
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validate thông tin
    if (empty($username)) {
        $errors['username'] = 'Chưa nhập tên người dùng';
    } elseif ($employee->getUserByUsername($username)) {
        $errors['username'] = 'Tên người dùng đã tồn tại';
    }

    if (empty($password)) {
        $errors['password'] = 'Chưa nhập mật khẩu';
    }

    if ($password !== $confirmPassword) {
        $errors['confirm_password'] = 'Mật khẩu xác nhận không khớp';
    }

    // Kiểm tra thông tin đăng ký nếu không có lỗi
    if (empty($errors)) {
        // Băm mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Thêm người dùng vào cơ sở dữ liệu
        $result = $employee->addUser($username, $hashedPassword);

        if ($result) {
            $_SESSION['success'] = 'Đăng ký thành công. Bạn có thể đăng nhập.';
            header('Location: login.php'); // Chuyển hướng đến trang đăng nhập
            exit();
        } else {
            $errors['db'] = 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
</head>
<body>
    <h1>Đăng ký</h1>
    <form method="post" action="">
        <table>
            <tr>
                <td>Tên người dùng</td>
                <td>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>"/>
                    <?php if (!empty($errors['username'])) echo '<span style="color:red;">' . htmlspecialchars($errors['username']) . '</span>'; ?>
                </td>
            </tr>
            <tr>
                <td>Mật khẩu</td>
                <td>
                    <input type="password" name="password"/>
                    <?php if (!empty($errors['password'])) echo '<span style="color:red;">' . htmlspecialchars($errors['password']) . '</span>'; ?>
                </td>
            </tr>
            <tr>
                <td>Xác nhận mật khẩu</td>
                <td>
                    <input type="password" name="confirm_password"/>
                    <?php if (!empty($errors['confirm_password'])) echo '<span style="color:red;">' . htmlspecialchars($errors['confirm_password']) . '</span>'; ?>
                </td>
            </tr>
            <?php if (!empty($errors['db'])) { ?>
            <tr>
                <td colspan="2" style="color:red;"><?php echo htmlspecialchars($errors['db']); ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="register" value="Đăng ký"/>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
