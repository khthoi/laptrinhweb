<?php
// Sử dụng require để gọi các hàm từ tệp math_functions.php
require 'Bai3-functions.php';

// Xử lý các phép tính toán
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['calculate'])) {
    $a = isset($_POST['a']) ? (float)$_POST['a'] : 0;
    $b = isset($_POST['b']) ? (float)$_POST['b'] : 0;

    $tong = tinhTong($a, $b);
    $hieu = tinhHieu($a, $b);
    $tich = tinhTich($a, $b);
    $thuong = tinhThuong($a, $b);
}

// Xử lý kiểm tra số nguyên tố
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check_prime'])) {
    $n = isset($_POST['n']) ? (int)$_POST['n'] : 0;

    $isNguyenTo = kiemTraNguyenTo($n) ? "là số nguyên tố" : "không phải là số nguyên tố";
    $isChan = kiemTraChan($n) ? "là số chẵn" : "là số lẻ";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phép tính toán và Kiểm tra số nguyên tố</title>
</head>
<body>
    <h1>Thực hiện các phép tính</h1>
    <form method="post" action="">
        <label for="a">Nhập số thứ nhất (a):</label>
        <input type="text" name="a" id="a" required><br><br>

        <label for="b">Nhập số thứ hai (b):</label>
        <input type="text" name="b" id="b" required><br><br>

        <input type="submit" name="calculate" value="Tính toán">
    </form>

    <?php if (isset($tong)): ?>
        <h2>Kết quả:</h2>
        <p>Tổng của <?php echo $a; ?> và <?php echo $b; ?> là: <?php echo $tong; ?></p>
        <p>Hiệu của <?php echo $a; ?> và <?php echo $b; ?> là: <?php echo $hieu; ?></p>
        <p>Tích của <?php echo $a; ?> và <?php echo $b; ?> là: <?php echo $tich; ?></p>
        <p>Thương của <?php echo $a; ?> và <?php echo $b; ?> là: <?php echo $thuong; ?></p>
    <?php endif; ?>

    <h1>Kiểm tra số nguyên tố</h1>
    <form method="post" action="">
        <label for="n">Nhập số cần kiểm tra (n):</label>
        <input type="text" name="n" id="n" required><br><br>

        <input type="submit" name="check_prime" value="Kiểm tra">
    </form>

    <?php if (isset($isNguyenTo)): ?>
        <h2>Kết quả:</h2>
        <p>Số <?php echo $n; ?> <?php echo $isNguyenTo; ?></p>
        <p>Số <?php echo $n; ?> <?php echo $isChan; ?></p>
    <?php endif; ?>
</body>
</html>
