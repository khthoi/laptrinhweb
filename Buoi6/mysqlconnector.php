<?php
class Database
{
    private $host = 'localhost';
    private $port = '3307';  // Sử dụng port 3307
    private $dbname = 'b5_mydb'; // Tên csdl
    private $username = 'root';
    private $password = '';  // Để trống nếu không có mật khẩu
    private $db;

    // Hàm khởi tạo để kết nối đến cơ sở dữ liệu
    public function __construct()
    {
        $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbname";
        try {
            $this->db = new PDO($dsn, $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            die();
        }
    }
    // Hàm lấy tất cả danh sách nhân viên
    public function getGuests()
    {
        $sql = "SELECT id, firstname, lastname, reg_date FROM myguests";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm cập nhật firstname
    public function updateGuest($oldFirstname, $newFirstname)
    {
        $sql = "UPDATE myguests SET firstname = :newFirstname WHERE firstname = :oldFirstname";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':newFirstname', $newFirstname);
        $stmt->bindParam(':oldFirstname', $oldFirstname);
        $stmt->execute();
        return $stmt->rowCount(); // Số hàng bị ảnh hưởng
    }

    // Hàm xóa nhân viên theo id
    public function deleteGuestById($id)
    {
        $sql = "DELETE FROM myguests WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount(); // Số hàng bị ảnh hưởng
    }

    // Hàm để chèn dữ liệu vào bảng myguests
    public function insertGuest($firstname, $lastname, $email)
    {
        $sql = "INSERT INTO myguests (firstname, lastname, email) VALUES (:firstname, :lastname, :email)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':firstname', $firstname); // liên kết một biến với một tham số trong câu lệnh SQL đã chuẩn bị sẵn
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            echo "Inserted: $firstname $lastname<br>";
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    // Hàm để đóng kết nối khi không còn cần thiết
    public function closeConnection()
    {
        $this->db = null;
    }
}
?>
