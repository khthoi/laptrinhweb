<?php

class Database {
    private $pdo;

    public function __construct($host = 'localhost', $port = '3307', $dbname = 'b5_mydb', $username = 'root', $password = '') {
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function disconnect() {
        $this->pdo = null; // Ngắt kết nối
    }

    // Get all students
    public function get_all_students() {
        $stmt = $this->pdo->query("SELECT * FROM sinhvien");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a student by ID
    public function get_student($student_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM sinhvien WHERE id = :id");
        $stmt->execute(['id' => $student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add a student
    public function add_student($student_name, $student_sex, $student_birthday) {
        $stmt = $this->pdo->prepare("INSERT INTO sinhvien (hoten, gioitinh, ngaysinh) VALUES (:name, :sex, :birthday)");
        return $stmt->execute([
            'name' => $student_name,
            'sex' => $student_sex,
            'birthday' => $student_birthday
        ]);
    }

    // Edit a student
    public function edit_student($student_id, $student_name, $student_sex, $student_birthday) {
        $stmt = $this->pdo->prepare("UPDATE sinhvien SET hoten = :name, gioitinh = :sex, ngaysinh = :birthday WHERE id = :id");
        return $stmt->execute([
            'id' => $student_id,
            'name' => $student_name,
            'sex' => $student_sex,
            'birthday' => $student_birthday
        ]);
    }

    // Delete a student
    public function delete_student($student_id) {
        $stmt = $this->pdo->prepare("DELETE FROM sinhvien WHERE id = :id");
        return $stmt->execute(['id' => $student_id]);
    }
}

// Ví dụ sử dụng lớp Database
$db = new Database();

// Thực hiện các thao tác
$students = $db->get_all_students();
// Thực hiện thêm, sửa, xóa sinh viên tùy thuộc vào yêu cầu
$db->disconnect();
?>
