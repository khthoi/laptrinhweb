<?php
require 'employee.php';
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Khởi tạo kết nối cơ sở dữ liệu
$db = new Database();
$employee = new Employee($db);

// Gọi hàm để lấy thông tin phòng ban và chức vụ
$roles = $employee->getAllRoles();
$departments = $employee->getAllDepartments();

$data = [];
$errors = [];

// Nếu người dùng submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_employee'])) {
    // Lấy dữ liệu
    $data['firstname'] = $_POST['firstname'] ?? '';
    $data['lastname'] = $_POST['lastname'] ?? '';
    $data['role'] = $_POST['role'] ?? '';
    $data['department'] = $_POST['department'] ?? '';
    $data['hiredate'] = $_POST['hiredate'] ?? '';
    $data['salary'] = $_POST['salary'] ?? '';
    $data['password'] = $_POST['password'] ?? '';

    // Validate thông tin
    if (empty($data['firstname'])) {
        $errors['firstname'] = 'Chưa nhập họ đệm nhân viên';
    }
    if (empty($data['lastname'])) {
        $errors['lastname'] = 'Chưa nhập tên nhân viên';
    }
    if (empty($data['hiredate'])) {
        $errors['hiredate'] = 'Chưa nhập ngày bắt đầu';
    }
    if (empty($data['salary']) || !is_numeric($data['salary'])) {
        $errors['salary'] = 'Chưa nhập lương hợp lệ';
    }
    if (empty($data['password'])) {
        $errors['password'] = 'Chưa nhập mật khẩu';
    }

    // Kiểm tra nếu chức vụ hoặc phòng ban chưa được chọn
    if (empty($data['role'])) {
        $errors['role'] = 'Chưa chọn chức vụ';
    }
    if (empty($data['department'])) {
        $errors['department'] = 'Chưa chọn phòng ban';
    }

    // Nếu không có lỗi, lấy RoleID và DepartmentID
    if (empty($errors)) {
        $role_id = $employee->getRoleID($data['role']);
        $department_id = $employee->getDepartmentID($data['department']);

        // Nếu RoleID và DepartmentID hợp lệ, thêm nhân viên vào CSDL
        if ($role_id && $department_id) {
            $employee->addEmployee($data['firstname'], $data['lastname'], $department_id, $role_id, $data['hiredate'], $data['salary'], $data['password']);
            // Trở về trang danh sách nhân viên
            header("Location: employee_list.php");
            exit(); // Dừng thực hiện sau khi chuyển hướng
        } else {
            $errors['role'] = 'Chức vụ hoặc phòng ban không hợp lệ.';
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
    <title>Thêm nhân viên</title>
</head>

<body>
    <h1>Thêm nhân viên</h1>
    <a href="employee_list.php">Trở về</a><br /><br />
    <form method="post" action="">
        <table width="50%" border="1" cellspacing="0" cellpadding="10">
            <tr>
                <td>First name</td>
                <td>
                    <input type="text" name="firstname" value="<?php echo htmlspecialchars($data['firstname'] ?? ''); ?>" />
                    <?php if (!empty($errors['firstname'])) echo '<span style="color:red;">' . htmlspecialchars($errors['firstname']) . '</span>'; ?>
                </td>
            </tr>
            <tr>
                <td>Last name</td>
                <td>
                    <input type="text" name="lastname" value="<?php echo htmlspecialchars($data['lastname'] ?? ''); ?>" />
                    <?php if (!empty($errors['lastname'])) echo '<span style="color:red;">' . htmlspecialchars($errors['lastname']) . '</span>'; ?>
                </td>
            </tr>
            <tr>
                <td>Chức Vụ</td>
                <td>
                    <select name="role">
                        <option value="">Chọn chức vụ</option>
                        <?php foreach ($roles as $item) { ?>
                            <option value="<?php echo htmlspecialchars($item['RoleName']); ?>" <?php echo ($data['role'] == $item['RoleName']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($item['RoleName']); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <?php if (!empty($errors['role'])) echo '<span style="color:red;">' . htmlspecialchars($errors['role']) . '</span>'; ?>
                </td>
            </tr>
            <tr>
                <td>Phòng Ban</td>
                <td>
                    <select name="department">
                        <option value="">Chọn phòng ban</option>
                        <?php foreach ($departments as $item) { ?>
                            <option value="<?php echo htmlspecialchars($item['DepartmentName']); ?>" <?php echo ($data['department'] == $item['DepartmentName']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($item['DepartmentName']); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <?php if (!empty($errors['department'])) echo '<span style="color:red;">' . htmlspecialchars($errors['department']) . '</span>'; ?>
                </td>
            </tr>
            <tr>
                <td>Ngày Thuê</td>
                <td>
                    <input type="date" name="hiredate" value="<?php echo htmlspecialchars($data['hiredate'] ?? ''); ?>" />
                    <?php if (!empty($errors['hiredate'])) echo '<span style="color:red;">' . htmlspecialchars($errors['hiredate']) . '</span>'; ?>
                </td>
            </tr>
            <tr>
                <td>Lương</td>
                <td>
                    <input type="number" name="salary" value="<?php echo htmlspecialchars($data['salary'] ?? ''); ?>" />
                    <?php if (!empty($errors['salary'])) echo '<span style="color:red;">' . htmlspecialchars($errors['salary']) . '</span>'; ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="add_employee" value="Lưu" />
                </td>
            </tr>
        </table>
    </form>
</body>
</html>