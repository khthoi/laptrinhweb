<?php
// Gọi file connector để kết nối cơ sở dữ liệu
include 'connector.php';

// Câu truy vấn lấy dữ liệu từ bảng sinhvien và diemthi
$sql = "
    SELECT sinhvien.name, sinhvien.gender, sinhvien.birthday, diemthi.subject_id, diemthi.score, diemthi.exam_date
    FROM sinhvien
    JOIN diemthi ON sinhvien.student_id = diemthi.student_id
";

try {
    // Chuẩn bị truy vấn
    $stmt = $pdo->prepare($sql);
    
    // Thực hiện truy vấn
    $stmt->execute();
    
    // Kiểm tra nếu có kết quả
    if ($stmt->rowCount() > 0) {
        // Tạo bảng HTML để hiển thị dữ liệu
        echo "<table border='1'>
                <tr>
                    <th>Tên sinh viên</th>
                    <th>Giới tính</th>
                    <th>Ngày sinh</th>
                    <th>Mã môn học</th>
                    <th>Điểm thi</th>
                    <th>Ngày thi</th>
                </tr>";
        
        // Lặp qua từng hàng dữ liệu
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["gender"] . "</td>
                    <td>" . $row["birthday"] . "</td>
                    <td>" . $row["subject_id"] . "</td>
                    <td>" . $row["score"] . "</td>
                    <td>" . $row["exam_date"] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "Không có kết quả.";
    }
} catch (PDOException $e) {
    // Thông báo lỗi nếu có vấn đề xảy ra
    echo "Lỗi truy vấn: " . $e->getMessage();
}

// Đóng kết nối
$pdo = null;
?>
