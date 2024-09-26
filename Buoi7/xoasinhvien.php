<?php
require 'sinhvien.php';

$db = new Database();

$id = isset($_POST['id']) ? (int)$_POST['id'] : '';
if ($id) {
    $db->delete_student($id);
}

header("Location: students_list.php");
exit();
?>
