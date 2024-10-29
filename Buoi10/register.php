<?php
require 'employee.php';
require 'check_login.php';
$db = new Database();
$employee = new Employee($db);

$errors = [];

// Nếu người dùng gửi form đăng ký
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Lấy dữ liệu
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? '';

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

    if (empty($role)) {
        $errors['role'] = 'Chưa chọn vai trò';
    }

    // Kiểm tra thông tin đăng ký nếu không có lỗi
    if (empty($errors)) {
        // Băm mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Thêm người dùng vào cơ sở dữ liệu
        $result = $employee->addUser($username, $hashedPassword, $role);

        if ($result) {
            // Xóa session trước khi chuyển hướng
            session_destroy();
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 50%;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            padding: 10px 15px;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Thêm người dùng (Quản trị viên)</h1>
    <form method="post" action="">
        <table>
            <tr>
                <td>Tên người dùng</td>
                <td>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" />
                    <?php if (!empty($errors['username'])) echo '<span class="error">' . htmlspecialchars($errors['username']) . '</span>'; ?>
                </td>
            </tr>
            <tr>
                <td>Mật khẩu</td>
                <td>
                    <input type="password" name="password" />
                    <?php if (!empty($errors['password'])) echo '<span class="error">' . htmlspecialchars($errors['password']) . '</span>'; ?>
                </td>
            </tr>
            <tr>
                <td>Xác nhận mật khẩu</td>
                <td>
                    <input type="password" name="confirm_password" />
                    <?php if (!empty($errors['confirm_password'])) echo '<span class="error">' . htmlspecialchars($errors['confirm_password']) . '</span>'; ?>
                </td>
            </tr>
            <tr>
                <td>Vai trò</td>
                <td>
                    <select name="role" required>
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                    </select>
                    <?php if (!empty($errors['role'])) echo '<span class="error">' . htmlspecialchars($errors['role']) . '</span>'; ?>
                </td>
            </tr>
            <?php if (!empty($errors['db'])) { ?>
                <tr>
                    <td colspan="2" class="error"><?php echo htmlspecialchars($errors['db']); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="register" value="Thêm người dùng" />
                </td>
            </tr>
        </table>
    </form>
</body>

</html>