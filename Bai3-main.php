<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phép Tính và Kiểm Tra Số</title>
</head>
<body>
    <h1>PHÉP TÍNH TRÊN HAI SỐ</h1>
    <form method="POST" action="">
        <fieldset>
            <legend>Chọn phép tính:</legend>
            <input type="radio" name="pheptinh" value="cong"> Cộng<br>
            <input type="radio" name="pheptinh" value="tru"> Trừ<br>
            <input type="radio" name="pheptinh" value="nhan"> Nhân<br>
            <input type="radio" name="pheptinh" value="chia"> Chia<br>
        </fieldset>
        <br>
        <label>Số thứ nhất:</label>
        <input type="number" name="so1" required><br>
        <label>Số thứ hai (nếu cần):</label>
        <input type="number" name="so2"><br><br>
        <input type="submit" name="tinh" value="Tính">
    </form>
    <!-- Label hiển thị kết quả phép tính -->
    <h2>Kết quả phép tính:</h2>
    <div id="ketqua_pheptinh">
        <?php
        require 'Bai3-functions.php';

        if (isset($_POST['tinh'])) {
            $so1 = $_POST['so1'];
            $so2 = $_POST['so2'] ?? 0;
            $pheptinh = $_POST['pheptinh'];

            switch ($pheptinh) {
                case 'cong':
                    $ketqua = tinhTong($so1, $so2);
                    break;
                case 'tru':
                    $ketqua = tinhHieu($so1, $so2);
                    break;
                case 'nhan':
                    $ketqua = tinhTich($so1, $so2);
                    break;
                case 'chia':
                    $ketqua = tinhThuong($so1, $so2);
                    break;
                default:
                    $ketqua = "Chọn phép tính hợp lệ!";
            }

            echo $ketqua;
        }
        ?>
    </div>

    <h1>KIỂM TRA SỐ</h1>
    <form method="POST" action="">
        <fieldset>
            <legend>Chọn phép kiểm tra:</legend>
            <input type="radio" name="kieutra" value="chanle"> Kiểm tra số chẵn/lẻ<br>
            <input type="radio" name="kieutra" value="nguyento"> Kiểm tra số nguyên tố<br>
        </fieldset>
        <br>
        <label>Số cần kiểm tra:</label>
        <input type="number" name="so_can_kiem_tra" required><br><br>
        <input type="submit" name="kiemtra" value="Kiểm tra">
    </form>

    <!-- Label hiển thị kết quả kiểm tra số -->
    <h2>Kết quả kiểm tra số:</h2>
    <div id="ketqua_kiemtraso">
        <?php
        if (isset($_POST['kiemtra'])) {
            $so = $_POST['so_can_kiem_tra'];
            $kieutra = $_POST['kieutra'];

            switch ($kieutra) {
                case 'chanle':
                    $ketqua = kiemTraChan($so) ? "Số $so là số chẵn" : "Số $so là số lẻ";
                    break;
                case 'nguyento':
                    $ketqua = kiemTraNguyenTo($so) ? "Số $so là số nguyên tố" : "Số $so không phải là số nguyên tố";
                    break;
                default:
                    $ketqua = "Chọn phép kiểm tra hợp lệ!";
            }

            echo $ketqua;
        }
        ?>
    </div>

</body>
</html>
