<?php
require_once 'mysqlconnector.php'; // Gọi class Database

$db = new Database();
$guests = $db->getGuests();

if ($guests) {
    echo "<h2>Danh sách nhân viên</h2>";
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
    echo "Không có dữ liệu nào!";
}
// Đóng kết nối sau khi hoàn thành
$db->closeConnection();
