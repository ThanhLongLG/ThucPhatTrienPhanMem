<?php
    require_once __DIR__ . '/../../helpers/SessionHelper.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Quản lý sản phẩm</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/TranThanhLong/Product/">Danh sách sản phẩm</a>
                        </li>
                        <?php if (SessionHelper::isAdmin()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/TranThanhLong/Product/add">Thêm sản phẩm</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    
                    <ul class="navbar-nav ml-auto">
                        <?php if(SessionHelper::isLoggedIn()): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo htmlspecialchars($_SESSION['username'])."(" . SessionHelper::getRole() . ")"; ?>
                               
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Hồ sơ</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" onclick="logout()">Đăng xuất</a>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/TranThanhLong/account/login">Đăng nhập</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/TranThanhLong/account/register">Đăng ký</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container mt-4">
            <!-- Nội dung chính sẽ được thêm vào đây -->
        </div>
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    <script>
        function logout() {
            localStorage.removeItem('jwtToken');
                location.href = '/TranThanhLong/account/login';
            }
            document.addEventListener("DOMContentLoaded", function() {
                const token = localStorage.getItem('jwtToken');
                if (token) {
                    document.getElementById('nav-login').style.display = 'none';
                    document.getElementById('nav-logout').style.display = 'block';
                } else {
                    document.getElementById('nav-login').style.display = 'block';
                    document.getElementById('nav-logout').style.display = 'none';
                }
        });
        
    </script>
</html>
