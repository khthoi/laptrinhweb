<?php
session_start();
require 'Bai3-functions.php';

// Khởi tạo biến kết quả
$ketqua_pheptinh = isset($_SESSION['ketqua_pheptinh']) ? $_SESSION['ketqua_pheptinh'] : '';
$ketqua_kiemtraso = isset($_SESSION['ketqua_kiemtraso']) ? $_SESSION['ketqua_kiemtraso'] : '';

// Xử lý phép tính trên hai số
if (isset($_POST['tinh'])) {
    $so1 = isset($_POST['so1']) ? intval($_POST['so1']) : 0;
    $so2 = isset($_POST['so2']) ? intval($_POST['so2']) : 0;
    $pheptinh = isset($_POST['pheptinh']) ? $_POST['pheptinh'] : '';

    if ($pheptinh) {
        switch ($pheptinh) {
            case 'cong':
                $ketqua_pheptinh = tinhTong($so1, $so2);
                break;
            case 'tru':
                $ketqua_pheptinh = tinhHieu($so1, $so2);
                break;
            case 'nhan':
                $ketqua_pheptinh = tinhTich($so1, $so2);
                break;
            case 'chia':
                if ($so2 != 0) {
                    $ketqua_pheptinh = tinhThuong($so1, $so2);
                } else {
                    $ketqua_pheptinh = "Không thể chia cho 0!";
                }
                break;
            default:
                $ketqua_pheptinh = "Chọn phép tính hợp lệ!";
        }
    } else {
        $ketqua_pheptinh = "Vui lòng chọn một phép tính.";
    }

    $_SESSION['ketqua_pheptinh'] = $ketqua_pheptinh;
}

// Xử lý kiểm tra số
if (isset($_POST['kiemtra'])) {
    $so = isset($_POST['so_can_kiem_tra']) ? intval($_POST['so_can_kiem_tra']) : 0;
    $kieutra = isset($_POST['kieutra']) ? $_POST['kieutra'] : '';

    if ($kieutra) {
        switch ($kieutra) {
            case 'chanle':
                $ketqua_kiemtraso = kiemTraChan($so) ? "Số $so là số chẵn" : "Số $so là số lẻ";
                break;
            case 'nguyento':
                $ketqua_kiemtraso = kiemTraNguyenTo($so) ? "Số $so là số nguyên tố" : "Số $so không phải là số nguyên tố";
                break;
            default:
                $ketqua_kiemtraso = "Chọn phép kiểm tra hợp lệ!";
        }
    } else {
        $ketqua_kiemtraso = "Vui lòng chọn một phép kiểm tra.";
    }

    $_SESSION['ketqua_kiemtraso'] = $ketqua_kiemtraso;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phép Tính và Kiểm Tra Số</title>
    <link rel="stylesheet" href="Bai3-styles.css"> 
</head>
<body>
    <h1>PHÉP TÍNH TRÊN HAI SỐ</h1>
    <fieldset>
        <form method="POST" action="">
            <legend>Chọn phép tính:</legend>
            <input type="radio" name="pheptinh" value="cong"> Cộng<br>
            <input type="radio" name="pheptinh" value="tru"> Trừ<br>
            <input type="radio" name="pheptinh" value="nhan"> Nhân<br>
            <input type="radio" name="pheptinh" value="chia"> Chia<br>
            <br>
            <label>Số thứ nhất:</label>
            <input type="number" name="so1" required><br>
            <label>Số thứ hai (nếu cần):</label>
            <input type="number" name="so2"><br><br>
            <input type="submit" name="tinh" value="Tính">
        </form>

        <!-- Label hiển thị kết quả phép tính -->
        <h2>Kết quả phép tính:</h2>
        <!-- Hiển thị kết quả phép tính -->
        <?php if (!empty($ketqua_pheptinh)): ?>
            <p class="result"><?php echo $ketqua_pheptinh; ?></p>
        <?php endif; ?>

    </fieldset>

    <h1>KIỂM TRA SỐ</h1>
    <fieldset>
        <form method="POST" action="">  
            <legend>Chọn phép kiểm tra:</legend>
            <input type="radio" name="kieutra" value="chanle"> Kiểm tra số chẵn/lẻ<br>
            <input type="radio" name="kieutra" value="nguyento"> Kiểm tra số nguyên tố
            <br><br>
            <label>Số cần kiểm tra:</label>
            <input type="number" name="so_can_kiem_tra" required><br><br>
            <input type="submit" name="kiemtra" value="Kiểm tra">
        </form>

        <!-- Label hiển thị kết quả kiểm tra số -->
        <h2>Kết quả kiểm tra số:</h2>
        <!-- Hiển thị kết quả kiểm tra số -->
        <?php if (!empty($ketqua_kiemtraso)): ?>
            <p class="result"><?php echo $ketqua_kiemtraso; ?></p>
        <?php endif; ?>
    </fieldset>
</body>
</html>
