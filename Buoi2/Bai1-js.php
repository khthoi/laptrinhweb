<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form Thông Tin Sách</title>
</head>
<body>
    <h1>Nhập Thông Tin Sách</h1>
    <form name="bookForm" action="" method="post" onsubmit="return validateForm();">
        <div id="errorMessages"></div>

        <label for="tenSach">Tên sách:</label><br>
        <input type="text" id="tenSach" name="tenSach" value="<?php echo isset($_POST['tenSach']) ? htmlspecialchars($_POST['tenSach']) : ''; ?>"><br><br>

        <label for="tacGia">Tác giả:</label><br>
        <input type="text" id="tacGia" name="tacGia" value="<?php echo isset($_POST['tacGia']) ? htmlspecialchars($_POST['tacGia']) : ''; ?>"><br><br>

        <label for="nhaXuatBan">Nhà xuất bản:</label><br>
        <input type="text" id="nhaXuatBan" name="nhaXuatBan" value="<?php echo isset($_POST['nhaXuatBan']) ? htmlspecialchars($_POST['nhaXuatBan']) : ''; ?>"><br><br>

        <label for="namXuatBan">Năm xuất bản:</label><br>
        <input type="text" id="namXuatBan" name="namXuatBan" value="<?php echo isset($_POST['namXuatBan']) ? htmlspecialchars($_POST['namXuatBan']) : ''; ?>"><br><br>

        <input type="submit" name="hienthi" value="Hiển thị thông tin">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hienthi'])) {
        // Hiển thị thông tin nếu dữ liệu hợp lệ (client-side validation)
        echo "<h2>Thông tin sách đã nhập:</h2>";
        echo "Tên sách: " . htmlspecialchars($_POST['tenSach']) . "<br>";
        echo "Tác giả: " . htmlspecialchars($_POST['tacGia']) . "<br>";
        echo "Nhà xuất bản: " . htmlspecialchars($_POST['nhaXuatBan']) . "<br>";
        echo "Năm xuất bản: " . htmlspecialchars($_POST['namXuatBan']) . "<br>";
    }
    ?>
</body>
<script src='Bai1-js.js'></script>
</html>
