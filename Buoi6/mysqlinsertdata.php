<?php
require_once 'mysqlconnector.php'; // Gọi class Database

// Sử dụng lớp Database
$db = new Database();
$db->insertGuest('John', 'Doe', 'john@example.com');
$db->insertGuest('Jane', 'Smith', 'jane@example.com');
$db->insertGuest('James', 'Johnson', 'james@example.com');
$db->insertGuest('Emily', 'Brown', 'emily@example.com');
$db->insertGuest('Michael', 'Davis', 'michael@example.com');

// Đóng kết nối sau khi hoàn thành
$db->closeConnection();
