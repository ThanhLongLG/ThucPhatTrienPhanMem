<?php 
    require_once('app/config/database.php'); 
    require_once('app/models/AccountModel.php'); 
    require_once('app/utils/JWTHandler.php');
    class AccountController { 
        private $accountModel;
        private $db;
        private $jwtHandler;

        public function __construct() { 
            $this->db = (new Database())->getConnection(); 
            $this->accountModel = new AccountModel($this->db);
            $this->jwtHandler = new JWTHandler();
        } 
        public function register() { 
            include_once 'app/views/account/register.php'; 
        } 
        public function login() { 
            include_once 'app/views/account/login.php'; 
        } 

        public function save() { 
            if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
                $username = $_POST['username'] ?? ''; 
                $fullName = $_POST['fullname'] ?? ''; 
                $password = $_POST['password'] ?? ''; 
                $confirmPassword = $_POST['confirmpassword'] ?? ''; 
                $role = $_POST['role'] ?? 'user'; 
                $errors = []; 
                if (empty($username)) $errors['username'] = "Vui lòng nhập username!"; 
                if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập fullname!"; 
                if (empty($password)) $errors['password'] = "Vui lòng nhập password!"; 
                if ($password != $confirmPassword) $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!"; 
                if (!in_array($role, ['admin', 'user'])) $role = 'user'; 
                if ($this->accountModel->getAccountByUsername($username)) { 
                    $errors['account'] = "Tài khoản này đã được đăng ký!"; 
                } 
                if (count($errors) > 0) { 
                    include_once 'app/views/account/register.php'; 
                } else { 
                    $result = $this->accountModel->save($username, $fullName, $password, 
                    $role); 
                } 
                if ($result) { 
                    header('Location: /TranThanhLong/account/login'); 
                    exit; 
                } 
            } 
        }
        public function logout() {
            session_start(); 
            unset($_SESSION['username']); 
            unset($_SESSION['role']); 
            header('Location: /TranThanhLong/product'); 
            exit; 
        }
        
        public function checkLogin() {
            // Kiểm tra nếu là JSON
            $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
            if (strpos($contentType, 'application/json') !== false) {
                $data = json_decode(file_get_contents('php://input'), true);
                $username = $data['username'] ?? '';
                $password = $data['password'] ?? '';
            } else {
                $username = $_POST['username'] ?? '';
                $password = $_POST['password'] ?? '';
            }

            $account = $this->accountModel->getAccountByUsername($username); 
            if ($account && password_verify($password, $account->password)) { 
                // Tạo JWT
                $token = $this->jwtHandler->encode([
                    'username' => $account->username,
                    'role' => $account->role,
                    'exp' => time() + 3600
                ]);
                header('Content-Type: application/json');
                echo json_encode(['token' => $token]);
                exit;
            } else { 
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Đăng nhập thất bại']);
                exit;
            }
        }
    }
?>