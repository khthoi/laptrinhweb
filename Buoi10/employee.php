<?php
class Database
{
    private $host = 'localhost';
    private $dbname = 'buoi9';
    private $username = 'root';
    private $password = '';
    private $port = 3307; // MySQL port

    // Connect to the database
    public function connect()
    {
        try {
            $conn = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }

    // Disconnect from the database
    public function disconnect($conn)
    {
        $conn = null;
    }
}

class Employee
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Get all employees
    public function getAllEmployees()
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT departments.DepartmentID, employeeroles.RoleID, employees.EmployeeID, 
                                 employees.FirstName, employees.LastName, departments.DepartmentName, employees.HireDate, employees.Salary,
                                 employeeroles.RoleName 
                                 FROM employees 
                                 JOIN departments ON employees.DepartmentID = departments.DepartmentID 
                                 JOIN employeeroles ON employees.RoleID = employeeroles.RoleID");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get employee by ID
    public function getEmployee($employee_id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT * FROM employees WHERE EmployeeID = :employee_id");
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add employee with password encryption
    // Add employee
    public function addEmployee($first_name, $last_name, $department_id, $role_id, $hiredate, $salary)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("INSERT INTO employees (FirstName, LastName, DepartmentID, RoleID, HireDate, Salary) 
                                 VALUES (:first_name, :last_name, :department_id, :role_id, :hiredate, :salary)");
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':department_id', $department_id);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->bindParam(':hiredate', $hiredate);
        $stmt->bindParam(':salary', $salary);
        $stmt->execute();
        echo "Employee added successfully!";
        $this->db->disconnect($conn);
    }

    // Edit employee
    public function editEmployee($employee_id, $first_name, $last_name, $department_id, $role_id, $hiredate, $salary)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("UPDATE employees 
                                 SET FirstName = :first_name, LastName = :last_name, 
                                     DepartmentID = :department_id, RoleID = :role_id, 
                                     HireDate = :hiredate, Salary = :salary
                                 WHERE EmployeeID = :employee_id");
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':department_id', $department_id);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->bindParam(':hiredate', $hiredate);
        $stmt->bindParam(':salary', $salary);
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->execute();
        echo "Employee updated successfully!";
        $this->db->disconnect($conn);
    }

    // Delete employee
    public function deleteEmployee($employee_id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("DELETE FROM employees WHERE EmployeeID = :employee_id");
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->execute();
        echo "Employee deleted successfully!";
        $this->db->disconnect($conn);
    }

    // Get all roles
    public function getAllRoles()
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT * FROM employeeroles");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all departments
    public function getAllDepartments()
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT * FROM departments");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Get RoleID from role name
    public function getRoleID($role_name)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT RoleID FROM employeeroles WHERE RoleName = :role_name");
        $stmt->bindParam(':role_name', $role_name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['RoleID'] ?? null;
    }

    // Get DepartmentID from department name
    public function getDepartmentID($department_name)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT DepartmentID FROM departments WHERE DepartmentName = :department_name");
        $stmt->bindParam(':department_name', $department_name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['DepartmentID'] ?? null;
    }

    // Get RoleName from RoleID
    public function getRoleName($role_id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT RoleName FROM employeeroles WHERE RoleID = :role_id");
        $stmt->bindParam(':role_id', $role_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['RoleName'] ?? null;
    }

    // Get DepartmentName from DepartmentID
    public function getDepartmentName($department_id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT DepartmentName FROM departments WHERE DepartmentID = :department_id");
        $stmt->bindParam(':department_id', $department_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['DepartmentName'] ?? null;
    }
    public function getUserByUsername($username)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT * FROM employees WHERE FirstName = :username OR LastName = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->db->disconnect($conn);
        return $user;
    }
    
    public function addUser($username, $hashedPassword)
    {
        $conn = $this->db->connect();

        // Thêm người dùng vào bảng users
        $stmt = $conn->prepare("INSERT INTO users (Username, PasswordHash, Role) VALUES (:username, :passwordHash, 'user')");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':passwordHash', $hashedPassword);
        return $stmt->execute();
    }

    // Authentication method for login
    public function login($username, $password)
    {
        $conn = $this->db->connect();

        // Lấy thông tin người dùng từ bảng users
        $stmt = $conn->prepare("SELECT * FROM users WHERE Username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra mật khẩu
        if ($user && password_verify($password, $user['PasswordHash'])) {
            // Bắt đầu phiên và lưu thông tin người dùng
            session_start();
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['role'] = $user['Role'];
            return true;
        } else {
            return false;
        }
    }

    // Logout method
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }

    // Check if user is logged in
    public function isLoggedIn()
    {
        session_start();
        return isset($_SESSION['user_id']);
    }

    // Check user role
    public function checkRole($required_role)
    {
        session_start();
        return isset($_SESSION['role']) && $_SESSION['role'] == $required_role;
    }
}
