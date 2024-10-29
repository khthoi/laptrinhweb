<?php
require 'employee.php';
require 'check_login.php';

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

    // Lấy RoleID và DepartmentID
    $role_id = $employee->getRoleID($data['role']);
    $department_id = $employee->getDepartmentID($data['department']);

    // Nếu không có lỗi thì insert
    if (empty($errors)) {
        $employee->addEmployee($data['firstname'], $data['lastname'], $department_id, $role_id, $data['hiredate'], $data['salary']);
        // Trở về trang danh sách
        header("Location: employee_list.php");
        exit(); // Dừng thực hiện sau khi chuyển hướng
    }
}

// Ngắt kết nối
$db->disconnect($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm nhân viên</title>
</head>
<body>
    <h1>Thêm nhân viên</h1>
    <a href="employee_list.php">Trở về</a><br/><br/>
    <form method="post" action="">
        <table width="50%" border="1" cellspacing="0" cellpadding="10">
            <tr>
                <td>First name</td>
                <td>
                    <input type="text" name="firstname" value="<?php echo htmlspecialchars($data['firstname'] ?? ''); ?>"/>
                    <?php if (!empty($errors['firstname'])) echo htmlspecialchars($errors['firstname']); ?>
                </td>
            </tr>
            <tr>
                <td>Last name</td>
                <td>
                    <input type="text" name="lastname" value="<?php echo htmlspecialchars($data['lastname'] ?? ''); ?>"/>
                    <?php if (!empty($errors['lastname'])) echo htmlspecialchars($errors['lastname']); ?>
                </td>
            </tr>
            <tr>
                <td>Chức Vụ</td>
                <td>
                    <select name="role">
                        <?php foreach ($roles as $item) { ?>
                            <option value="<?php echo htmlspecialchars($item['RoleName']); ?>"><?php echo htmlspecialchars($item['RoleName']); ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Phòng Ban</td>
                <td>
                    <select name="department">
                        <?php foreach ($departments as $item) { ?>
                            <option value="<?php echo htmlspecialchars($item['DepartmentName']); ?>"><?php echo htmlspecialchars($item['DepartmentName']); ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Ngày Thuê</td>
                <td>
                    <input type="date" name="hiredate" value="<?php echo htmlspecialchars($data['hiredate'] ?? ''); ?>"/>
                    <?php if (!empty($errors['hiredate'])) echo htmlspecialchars($errors['hiredate']); ?>
                </td>
            </tr>
            <tr>
                <td>Lương</td>
                <td>
                    <input type="number" name="salary" value="<?php echo htmlspecialchars($data['salary'] ?? ''); ?>"/>
                    <?php if (!empty($errors['salary'])) echo htmlspecialchars($errors['salary']); ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="add_employee" value="Lưu"/>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
