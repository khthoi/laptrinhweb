<?php
// Thông tin kết nối cơ sở dữ liệu
$servername = "localhost"; // Tên máy chủ
$username = "root"; // Tên người dùng MySQL
$password = ""; // Mật khẩu MySQL
$dbname = "baitap2"; // Tên cơ sở dữ liệu
$port = 3307; // Port của MySQL (thường là 3306, hoặc 3307 trong một số trường hợp)

// Thiết lập DSN (Data Source Name)
$dsn = "mysql:host=$servername;dbname=$dbname;port=$port;charset=utf8";

try {
    // Tạo đối tượng PDO để kết nối cơ sở dữ liệu
    $pdo = new PDO($dsn, $username, $password);
    
    // Thiết lập chế độ lỗi PDO là ngoại lệ
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Thông báo lỗi nếu kết nối thất bại
    die("Kết nối thất bại: " . $e->getMessage());
}
?>
