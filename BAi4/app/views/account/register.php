<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4>Đăng ký tài khoản</h4>
                </div>
                
                <!-- Hiển thị lỗi -->
                <?php if (isset($errors)): ?>
                    <div class="alert alert-danger mx-3 mt-3 mb-0">
                        <ul class="mb-0">
                            <?php foreach ($errors as $err): ?>
                                <li><?php echo htmlspecialchars($err); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <div class="card-body p-4">
                    <form class="user" action="/webbanhang/account/save" method="post">
                        <div class="form-group">
                            <label for="username">Tên đăng nhập</label>
                            <input type="text" class="form-control form-control-user" id="username" 
                                   name="username" placeholder="Nhập tên đăng nhập" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="fullname">Họ và tên</label>
                            <input type="text" class="form-control form-control-user" id="fullname" 
                                   name="fullname" placeholder="Nhập họ và tên đầy đủ" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control form-control-user" 
                                       id="password" name="password" placeholder="Nhập mật khẩu" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirmpassword">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control form-control-user" 
                                       id="confirmpassword" name="confirmpassword" 
                                       placeholder="Nhập lại mật khẩu" required>
                            </div>
                        </div>
                        
                        <div class="form-group mt-4 text-center">
                            <button type="submit" class="btn btn-primary btn-user px-5 py-2">
                                <i class="fas fa-user-plus mr-2"></i> Đăng ký
                            </button>
                        </div>
                        
                        <hr>
                        <div class="text-center">
                            <a class="small" href="/TranThanhLong/account/login">
                                Đã có tài khoản? Đăng nhập ngay!
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
