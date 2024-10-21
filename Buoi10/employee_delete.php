<?php
require 'employee.php';

// Instantiate the Employee class
$employee = new Employee();

// Get the employee ID from the POST request
$id = isset($_POST['id']) ? (int)$_POST['id'] : '';

if ($id) {
    // Use the deleteEmployee method from the Employee class
    $employee->deleteEmployee($id);
}

// Redirect back to the employee list
header("Location: employee_list.php");
exit();
?>
