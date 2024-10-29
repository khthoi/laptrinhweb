<?php
require 'employee.php';

// Khởi tạo kết nối cơ sở dữ liệu
$db = new Database();
$employee = new Employee($db);

// Lấy danh sách nhân viên
$employees = $employee->getAllEmployees();

// Ngắt kết nối
$db->disconnect($db);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên</title>
</head>

<body>
    <h1>Danh sách nhân viên</h1>
    <a href="employee_add.php">Thêm nhân viên</a><br /><br />
    <table width="100%" border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>First name</th>
            <th>Last name</th>
            <th>Chức Vụ</th>
            <th>Phòng Ban</th>
            <th>Ngày Thuê</th>
            <th>Lương</th>
            <th>Chọn thao tác</th>
        </tr>
        <?php if (!empty($employees)) { ?>
            <?php foreach ($employees as $item) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['FirstName']); ?></td>
                    <td><?php echo htmlspecialchars($item['LastName']); ?></td>
                    <td><?php echo htmlspecialchars($item['RoleName']); ?></td>
                    <td><?php echo htmlspecialchars($item['DepartmentName']); ?></td>
                    <td><?php echo htmlspecialchars($item['HireDate']); ?></td> <!-- Hire Date Column -->
                    <td><?php echo htmlspecialchars($item['Salary']); ?></td> <!-- Salary Column -->
                    <td>
                        <form method="post" action="employee_delete.php">
                            <input type="button" value="Sửa" onclick="window.location = 'employee_edit.php?id=<?php echo $item['EmployeeID']; ?>'" />
                            <input type="hidden" name="id" value="<?php echo $item['EmployeeID']; ?>" />
                            <input type="submit" name="delete" value="Xóa" onclick="return confirm('Bạn có chắc muốn xóa không?');" />
                        </form>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="7">Không có nhân viên nào.</td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>