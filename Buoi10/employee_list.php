<?php
require 'employee.php';
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Kiểm tra quyền của người dùng (chỉ cho phép truy cập nếu có quyền quản lý nhân viên)
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập vào trang này.";
    exit();
}

// Khởi tạo kết nối cơ sở dữ liệu
$db = new Database();
$employee = new Employee($db);

// Lấy danh sách nhân viên qua Ajax
$employees = $employee->getAllEmployees();
?>
 
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Sử dụng Ajax để xóa nhân viên
        function deleteEmployee(employeeID) {
            if (confirm('Bạn có chắc muốn xóa không?')) {
                $.ajax({
                    url: 'employee_delete.php',
                    type: 'POST',
                    data: { id: employeeID },
                    success: function(response) {
                        alert(response);
                        location.reload(); // Tải lại trang sau khi xóa thành công
                    }
                });
            }
        }
    </script>
</head>
<body>
    <h1>Danh sách nhân viên</h1>
    <a href="employee_add.php">Thêm nhân viên</a><br/><br/>
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
                <td><?php echo htmlspecialchars($item['HireDate']); ?></td>
                <td><?php echo htmlspecialchars($item['Salary']); ?></td>
                <td>
                    <button onclick="window.location = 'employee_edit.php?id=<?php echo $item['EmployeeID']; ?>'">Sửa</button>
                    <button onclick="deleteEmployee(<?php echo $item['EmployeeID']; ?>)">Xóa</button>
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
