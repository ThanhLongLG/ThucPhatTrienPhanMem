<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mb-4">Giỏ hàng của bạn</h1>
            
            <?php if (!empty($cart)): ?>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" width="120">Ảnh</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col" class="text-end">Giá</th>
                                    <th scope="col" width="150">Số lượng</th>
                                    <th scope="col" class="text-end">Thành tiền</th>
                                    <th scope="col" width="50"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart as $id => $item): ?>
                                <tr>
                                    <td>
                                        <?php if ($item['image']): ?>
                                        <img src="/TranThanhLong/public/uploads/products/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" 
                                             class="img-thumbnail" 
                                             alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle">
                                        <h5 class="mb-0"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                    </td>
                                    <td class="align-middle text-end">
                                        <?php echo number_format($item['price'], 0, ',', '.'); ?> VND
                                    </td>
                                    <td class="align-middle">
                                        <div class="input-group">
                                            <input type="number" class="form-control" 
                                                   value="<?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?>" 
                                                   min="1">
                                           
                                        </div>
                                    </td>
                                    <td class="align-middle text-end fw-bold">
                                        <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND
                                    </td>
                                  
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                                    <td class="text-end fw-bold text-danger">
                                        <?php 
                                        $total = array_reduce($cart, function($sum, $item) {
                                            return $sum + ($item['price'] * $item['quantity']);
                                        }, 0);
                                        echo number_format($total, 0, ',', '.'); ?> VND
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="/TranThanhLong/Product" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i> Tiếp tục mua sắm
                        </a>
                        <a href="/TranThanhLong/Product/checkout" class="btn btn-success">
                            <i class="fas fa-credit-card me-2"></i> Thanh toán
                        </a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                    <h3 class="text-muted">Giỏ hàng của bạn đang trống</h3>
                    <p class="text-muted">Hãy thêm sản phẩm vào giỏ hàng để bắt đầu mua sắm</p>
                    <a href="/TranThanhLong/Product" class="btn btn-primary mt-3">
                        <i class="fas fa-store me-2"></i> Mua sắm ngay
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>