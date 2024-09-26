<?php
require_once 'mysqlconnector.php'; // Gọi class Database

$db = new Database();
$affectedRows = $db->updateGuest('James', 'Jane');

if ($affectedRows > 0) {
    echo "Đã cập nhật thành công!<br>";
    // Hiển thị lại danh sách sau khi sửa
    $guests = $db->getGuests();
    echo "<h2>Danh sách nhân viên sau khi sửa</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Id</th><th>Firstname</th><th>Lastname</th><th>Reg_Date</th></tr>";

    foreach ($guests as $guest) {
        echo "<tr>";
        echo "<td>{$guest['id']}</td>";
        echo "<td>{$guest['firstname']}</td>";
        echo "<td>{$guest['lastname']}</td>";
        echo "<td>{$guest['reg_date']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Không có thay đổi nào.";
}
// Đóng kết nối sau khi hoàn thành
$db->closeConnection();
