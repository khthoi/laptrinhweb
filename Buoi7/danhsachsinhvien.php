<?php
require 'sinhvien.php';

// Khởi tạo kết nối cơ sở dữ liệu
$db = new Database();
$students = $db->get_all_students();
$db->disconnect();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
</head>
<body>
    <h1>Danh sách sinh viên</h1>
    <a href="themsinhvien.php">Thêm sinh viên</a> <br/> <br/>
    <table width="100%" border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Mã sinh viên</th>
                <th>Họ tên</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Chọn thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['id']); ?></td>
                <td><?php echo htmlspecialchars($item['hoten']); ?></td>
                <td><?php echo htmlspecialchars($item['gioitinh']); ?></td>
                <td><?php echo htmlspecialchars($item['ngaysinh']); ?></td>
                <td>
                    <form method="post" action="xoasinhvien.php" style="display: inline;">
                        <input type="button" value="Sửa" onclick="window.location = 'suasinhvien.php?id=<?php echo htmlspecialchars($item['id']); ?>'"/>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>"/>
                        <input type="submit" name="delete" value="Xóa" onclick="return confirm('Bạn có chắc muốn xóa không?');"/>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
