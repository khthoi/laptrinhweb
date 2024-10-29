<?php
require 'employee.php';
session_start();

// Khởi tạo kết nối cơ sở dữ liệu
$db = new Database();
$employee = new Employee($db);

// Lấy danh sách role và department
$roles = $employee->getAllRoles();
$departments = $employee->getAllDepartments();

// Lấy ID nhân viên từ URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : '';
if ($id) {
    $data = $employee->getEmployee($id);

    // Nếu không có dữ liệu tức không tìm thấy nhân viên cần sửa
    if (!$data) {
        header("location: employee_list.php");
        exit();
    }

    // Gán dữ liệu để hiển thị lên form
    $emid = $data['EmployeeID'];
    $emfirstname = $data['FirstName'];
    $emlastname = $data['LastName'];
    $emroleid = $data['RoleID'];
    $emdepartmentid = $data['DepartmentID'];
    $emhiredate = $data['HireDate'];
    $emsalary = $data['Salary'];
} else {
    // Nếu không có ID hợp lệ, chuyển về trang danh sách
    header("location: employee_list.php");
    exit();
}

// Nếu người dùng submit form
if (!empty($_POST['edit_employee'])) {
    // Lấy dữ liệu từ form
    $data['FirstName'] = $_POST['firstname'] ?? '';
    $data['LastName'] = $_POST['lastname'] ?? '';
    $data['DepartmentID'] = $_POST['department'] ?? '';
    $data['RoleID'] = $_POST['role'] ?? '';
    $data['HireDate'] = $_POST['hiredate'] ?? '';
    $data['Salary'] = $_POST['salary'] ?? '';
    $data['EmployeeID'] = $_POST['id'] ?? '';

    // Validate thông tin
    $errors = [];
    if (empty($data['FirstName'])) {
        $errors['firstname'] = 'Họ nhân viên không được bỏ trống';
    }

    if (empty($data['LastName'])) {
        $errors['lastname'] = 'Tên nhân viên không được bỏ trống';
    }

    if (empty($data['HireDate'])) {
        $errors['hiredate'] = 'Ngày bắt đầu không được bỏ trống';
    }

    if (empty($data['Salary']) || !is_numeric($data['Salary'])) {
        $errors['salary'] = 'Lương phải là một số hợp lệ';
    }

    // Nếu không có lỗi thì cập nhật
    if (empty($errors)) {
        // Cập nhật thông tin nhân viên
        $employee->editEmployee($data['EmployeeID'], $data['FirstName'], $data['LastName'], $data['DepartmentID'], $data['RoleID'], $data['HireDate'], $data['Salary']);

        // Trở về trang danh sách nhân viên
        header("location: employee_list.php");
        exit();
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
    <title>Sửa thông tin nhân viên</title>
</head>

<body>
    <h1>Sửa thông tin nhân viên</h1>
    <a href="employee_list.php">Trở về</a><br /><br />

    <form method="post" action="employee_edit.php?id=<?php echo $emid; ?>">
        <table width="50%" border="1" cellspacing="0" cellpadding="10">
            <tr>
                <td>First name</td>
                <td>
                    <input type="text" name="firstname" value="<?php echo htmlspecialchars($emfirstname); ?>" />
                    <?php if (!empty($errors['firstname'])) echo $errors['firstname']; ?>
                </td>
            </tr>
            <tr>
                <td>Last name</td>
                <td>
                    <input type="text" name="lastname" value="<?php echo htmlspecialchars($emlastname); ?>" />
                    <?php if (!empty($errors['lastname'])) echo $errors['lastname']; ?>
                </td>
            </tr>
            <tr>
                <td>Chức Vụ</td>
                <td>
                    <select name="role">
                        <?php foreach ($roles as $item) { ?>
                            <option value="<?php echo $item['RoleID']; ?>"
                                <?php echo ($item['RoleID'] == $emroleid) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($item['RoleName']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Phòng Ban</td>
                <td>
                    <select name="department">
                        <?php foreach ($departments as $item) { ?>
                            <option value="<?php echo $item['DepartmentID']; ?>"
                                <?php echo ($item['DepartmentID'] == $emdepartmentid) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($item['DepartmentName']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Ngày Thuê</td>
                <td>
                    <input type="date" name="hiredate" value="<?php echo htmlspecialchars($emhiredate); ?>" />
                    <?php if (!empty($errors['hiredate'])) echo $errors['hiredate']; ?>
                </td>
            </tr>
            <tr>
                <td>Lương</td>
                <td>
                    <input type="number" name="salary" value="<?php echo htmlspecialchars($emsalary); ?>" />
                    <?php if (!empty($errors['salary'])) echo $errors['salary']; ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="hidden" name="id" value="<?php echo $emid; ?>" />
                    <input type="submit" name="edit_employee" value="Lưu" />
                </td>
            </tr>
        </table>
    </form>
</body>

</html>