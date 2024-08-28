<?php
// Bắt đầu session
session_start();

// Sử dụng require để gọi các hàm từ tệp Bai4-functions.php
require 'Bai4-functions.php';

$array = isset($_POST['array']) ? array_map('intval', explode(' ', $_POST['array'])) : [];
$value = isset($_POST['value']) ? intval($_POST['value']) : null;
$result = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result['max'] = timGiaTriLonNhat($array);
    $result['min'] = timGiaTriNhoNhat($array);
    $result['sum'] = tinhTongMang($array);
    $result['exists'] = kiemTraPhanTu($array, $value) ? "Có" : "Không";
    $result['sorted_asc'] = sapXepTangDan($array);
    $result['sorted_desc'] = sapXepGiamDan($array);
    
    // Lưu kết quả vào session
    $_SESSION['result'] = $result;
    $_SESSION['array'] = $array;
    $_SESSION['value'] = $value;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xử lý mảng</title>
    <link rel="stylesheet" href="Bai4-styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Xử lý mảng trong PHP</h1>
        <form method="post" action="">
            <label for="array">Nhập mảng (các phần tử cách nhau bằng dấu cách):</label>
            <input type="text" name="array" id="array" required><br><br>

            <label for="value">Nhập giá trị để kiểm tra:</label>
            <input type="text" name="value" id="value"><br><br>

            <input type="submit" value="Xử lý">
        </form>

        <?php if (!empty($_SESSION['array'])): ?>
            <h2>Kết quả:</h2>
            <p>Giá trị lớn nhất trong mảng: <?php echo $_SESSION['result']['max']; ?></p>
            <p>Giá trị nhỏ nhất trong mảng: <?php echo $_SESSION['result']['min']; ?></p>
            <p>Tổng các phần tử trong mảng: <?php echo $_SESSION['result']['sum']; ?></p>
            <p>Giá trị <?php echo $_SESSION['value']; ?> có trong mảng: <?php echo $_SESSION['result']['exists']; ?></p>
            <p>Mảng sau khi sắp xếp tăng dần: <?php echo implode(', ', $_SESSION['result']['sorted_asc']); ?></p>
            <p>Mảng sau khi sắp xếp giảm dần: <?php echo implode(', ', $_SESSION['result']['sorted_desc']); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
