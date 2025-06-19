<?php include 'app/views/shares/header.php'; ?>

<section class="vh-100 gradient-custom mt-5 mb-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <form action="/TranThanhLong/account/save" method="post">
                            <div class="mb-md-5 mt-md-4 pb-4">

                                <h2 class="fw-bold mb-2 text-uppercase">Đăng ký</h2>
                                <p class="text-white-50 mb-5">Vui lòng điền thông tin để tạo tài khoản</p>

                                <!-- Hiển thị lỗi -->
                                <?php if (isset($errors)): ?>
                                    <div class="alert alert-danger text-start">
                                        <ul class="mb-0">
                                            <?php foreach ($errors as $err): ?>
                                                <li><?= htmlspecialchars($err) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <div class="form-outline form-white mb-4 text-start">
                                    <label class="form-label" for="username">Tên đăng nhập</label>
                                    <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Tên đăng nhập" required />
                                </div>

                                <div class="form-outline form-white mb-4 text-start">
                                    <label class="form-label" for="fullname">Họ và tên</label>
                                    <input type="text" name="fullname" id="fullname" class="form-control form-control-lg" placeholder="Họ và tên đầy đủ" required />
                                </div>

                                <div class="form-outline form-white mb-4 text-start">
                                    <label class="form-label" for="password">Mật khẩu</label>
                                    <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Mật khẩu" required />
                                </div>

                                <div class="form-outline form-white mb-4 text-start">
                                    <label class="form-label" for="confirmpassword">Xác nhận mật khẩu</label>
                                    <input type="password" name="confirmpassword" id="confirmpassword" class="form-control form-control-lg" placeholder="Nhập lại mật khẩu" required />
                                </div>

                                <div class="form-outline form-white mb-4 text-start">
                                    <label class="form-label" for="role">Vai trò</label>
                                    <select name="role" id="role" class="form-select form-select-lg bg-dark text-white" required>
                                        <option value="user">Người dùng</option>
                                        <option value="admin">Quản trị viên</option>
                                    </select>
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit">
                                    <i class="fas fa-user-plus me-2"></i> Đăng ký
                                </button>

                            </div>

                            <div>
                                <p class="mb-0">Đã có tài khoản? 
                                    <a href="/TranThanhLong/account/login" class="text-white-50 fw-bold">Đăng nhập ngay!</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>
