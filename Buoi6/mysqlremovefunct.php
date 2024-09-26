<?php
require_once 'mysqlconnector.php'; // Gọi class Database

$db = new Database();
$affectedRows = $db->deleteGuestById(3);

if ($affectedRows > 0) {
    echo "Đã xóa thành công nhân viên có id là 3!<br>";
    // Hiển thị lại danh sách sau khi xóa
    $guests = $db->getGuests();
    echo "<h2>Danh sách nhân viên sau khi xóa</h2>";
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
    echo "Không có nhân viên nào bị xóa.";
}
// Đóng kết nối sau khi hoàn thành
$db->closeConnection();
