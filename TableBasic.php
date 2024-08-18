<?php
// Tổng số sách giả định là 100
$total_books = 100;
// Số sách mỗi trang
$books_per_page = 10;

// Xác định trang hiện tại từ URL, mặc định là trang 1 nếu không có giá trị
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Tính toán vị trí bắt đầu
$start_index = ($page - 1) * $books_per_page;

// Tạo danh sách sách
$books = [];
for ($i = 1; $i <= $total_books; $i++) {
    $books[] = [
        'stt' => $i,
        'ten_sach' => "Ten sach$i",
        'noi_dung' => "Noi dung$i"
    ];
}

// Lấy dữ liệu cho trang hiện tại
$current_books = array_slice($books, $start_index, $books_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sách</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Danh sách sách</h1>
    <table>
        <tr>
            <th>STT</th>
            <th>Tên Sách</th>
            <th>Nội dung sách</th>
        </tr>
        <?php foreach ($current_books as $book): ?>
            <tr>
                <td><?php echo $book['stt']; ?></td>
                <td><?php echo $book['ten_sach']; ?></td>
                <td><?php echo $book['noi_dung']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div style="margin-top: 20px; text-align:center">
        <?php
        // Hiển thị phân trang
        $total_pages = ceil($total_books / $books_per_page);
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo "<strong>$i</strong> ";
            } else {
                echo "<a href=\"?page=$i\">$i</a> ";
            }
        }
        ?>
    </div>
</body>
</html>
