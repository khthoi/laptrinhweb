<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form Thông Tin Sách</title>
</head>
<body>
    <h1>Nhập Thông Tin Sách</h1>
    <form action="" method="post">
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
        // Lấy dữ liệu từ form
        $tenSach = trim($_POST['tenSach']);
        $tacGia = trim($_POST['tacGia']);
        $nhaXuatBan = trim($_POST['nhaXuatBan']);
        $namXuatBan = trim($_POST['namXuatBan']);

        // Khởi tạo mảng lỗi
        $errors = [];

        // Kiểm tra validate phía server
        if (empty($tenSach)) {
            $errors[] = "Tên sách không được để trống.";
        }
        if (empty($tacGia)) {
            $errors[] = "Tác giả không được để trống.";
        }
        if (empty($nhaXuatBan)) {
            $errors[] = "Nhà xuất bản không được để trống.";
        }
        if (empty($namXuatBan)) {
            $errors[] = "Năm xuất bản không được để trống.";
        } elseif (!is_numeric($namXuatBan) || strlen($namXuatBan) !== 4) {
            $errors[] = "Năm xuất bản không hợp lệ.";
        }

        // Nếu không có lỗi, hiển thị thông tin
        if (empty($errors)) {
            echo "<h2>Thông tin sách đã nhập:</h2>";
            echo "Tên sách: " . htmlspecialchars($tenSach) . "<br>";
            echo "Tác giả: " . htmlspecialchars($tacGia) . "<br>";
            echo "Nhà xuất bản: " . htmlspecialchars($nhaXuatBan) . "<br>";
            echo "Năm xuất bản: " . htmlspecialchars($namXuatBan) . "<br>";
        } else {
            // Hiển thị lỗi
            foreach ($errors as $error) {
                echo "<p style='color:red;'>$error</p>";
            }
        }
    }
    ?>
</body>
</html>
