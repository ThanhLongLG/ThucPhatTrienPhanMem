<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h1 class="mb-3 text-success">Đặt hàng thành công!</h1>
                    <p class="lead mb-4">Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xử lý thành công.</p>
                    
                    <div class="alert alert-info text-start">
                        <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Thông tin đơn hàng</h5>
                        <hr>
                        <p class="mb-1"><strong>Mã đơn hàng:</strong> #<?php echo uniqid(); ?></p>
                        <p class="mb-1"><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i'); ?></p>
                        <p class="mb-0"><strong>Tình trạng:</strong> <span class="badge bg-success">Đã xác nhận</span></p>
                    </div>
                    
                    <p class="text-muted mb-4">Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất để xác nhận đơn hàng.</p>
                    
                    <div class="d-flex justify-content-center gap-3">
                        <a href="/TranThanhLong/Product/Index" class="btn btn-primary px-4">
                            <i class="fas fa-shopping-bag me-2"></i> Tiếp tục mua sắm
                        </a>
        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>