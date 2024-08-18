<?php
// Hàm tìm giá trị lớn nhất trong mảng
function timGiaTriLonNhat($array) {
    return max($array);
}

// Hàm tìm giá trị nhỏ nhất trong mảng
function timGiaTriNhoNhat($array) {
    return min($array);
}

// Hàm tính tổng các phần tử trong mảng
function tinhTongMang($array) {
    return array_sum($array);
}

// Hàm kiểm tra phần tử có thuộc mảng hay không
function kiemTraPhanTu($array, $value) {
    return in_array($value, $array);
}

// Hàm sắp xếp mảng tăng dần
function sapXepTangDan($array) {
    sort($array);
    return $array;
}

// Hàm sắp xếp mảng giảm dần
function sapXepGiamDan($array) {
    rsort($array);
    return $array;
}
?>
