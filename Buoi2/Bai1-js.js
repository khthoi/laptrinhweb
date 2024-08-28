function validateForm() {
    let tenSach = document.getElementById('tenSach').value.trim();
    let tacGia = document.getElementById('tacGia').value.trim();
    let nhaXuatBan = document.getElementById('nhaXuatBan').value.trim();
    let namXuatBan = document.getElementById('namXuatBan').value.trim();

    let errors = [];

    // Kiểm tra trường Tên sách
    if (tenSach === '') {
        errors.push("Tên sách không được để trống.");
    }

    // Kiểm tra trường Tác giả
    if (tacGia === '') {
        errors.push("Tác giả không được để trống.");
    }

    // Kiểm tra trường Nhà xuất bản
    if (nhaXuatBan === '') {
        errors.push("Nhà xuất bản không được để trống.");
    }

    // Kiểm tra trường Năm xuất bản
    if (namXuatBan === '') {
        errors.push("Năm xuất bản không được để trống.");
    } else if (!/^\d{4}$/.test(namXuatBan)) {
        errors.push("Năm xuất bản phải là một số có 4 chữ số.");
    }

    // Hiển thị lỗi nếu có
    if (errors.length > 0) {
        let errorDiv = document.getElementById('errorMessages');
        errorDiv.innerHTML = '';
        errors.forEach(function (error) {
            let p = document.createElement('p');
            p.style.color = 'red';
            p.innerText = error;
            errorDiv.appendChild(p);
        });
        return false; // Không gửi form
    }

    return true; // Gửi form nếu không có lỗi
}