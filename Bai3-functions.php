<?php
// Hàm tính tổng hai số
function tinhTong($a, $b) {
    return $a + $b;
}

// Hàm tính hiệu hai số
function tinhHieu($a, $b) {
    return $a - $b;
}

// Hàm tính tích hai số
function tinhTich($a, $b) {
    return $a * $b;
}

// Hàm tính thương hai số
function tinhThuong($a, $b) {
    if ($b != 0) {
        return $a / $b;
    } else {
        return "Không thể chia cho 0";
    }
}

// Hàm kiểm tra số nguyên tố
function kiemTraNguyenTo($n) {
    if ($n < 2) {
        return false;
    }
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) {
            return false;
        }
    }
    return true;
}

// Hàm kiểm tra số chẵn
function kiemTraChan($n) {
    return $n % 2 == 0;
}
?>
