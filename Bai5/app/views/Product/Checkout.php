<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0"><i class="fas fa-credit-card me-2"></i> Thanh toán</h2>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="/TranThanhLong/Product/processCheckout">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required 
                                       placeholder="Nhập họ và tên đầy đủ">
                                <div class="invalid-feedback">
                                    Vui lòng nhập họ tên
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="phone" name="phone" required 
                                       placeholder="Nhập số điện thoại">
                                <div class="invalid-feedback">
                                    Vui lòng nhập số điện thoại
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="address" name="address" rows="3" required 
                                      placeholder="Nhập địa chỉ chi tiết (số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố)"></textarea>
                            <div class="invalid-feedback">
                                Vui lòng nhập địa chỉ giao hàng
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Phương thức thanh toán</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label" for="cod">
                                    <i class="fas fa-money-bill-wave me-2"></i> Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>

                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="/TranThanhLong/Product/cart" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Quay lại giỏ hàng
                            </a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-check-circle me-2"></i> Hoàn tất thanh toán
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Xử lý validation form
(function() {
    'use strict';
    
    // Lấy tất cả các form cần validation
    var forms = document.querySelectorAll('.needs-validation');
    
    // Lặp lại và ngăn chặn submit
    Array.prototype.slice.call(forms)
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                form.classList.add('was-validated');
            }, false);
        });
})();
</script>

<?php include 'app/views/shares/footer.php'; ?>