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
                                    <td class="align-middle text-end price-item">
                                        <?php echo number_format($item['price'], 0, ',', '.'); ?> VND
                                    </td>
                                    <td class="align-middle">
                                        <form action="/TranThanhLong/Product/updateCart" method="post" class="quantity-form">
                                            <div class="input-group" style="width: 120px;">
                                                <button type="button" class="btn btn-outline-secondary btn-sm minus-btn">-</button>
                                                <input type="number" name="quantity" class="form-control text-center quantity-input" 
                                                    value="<?php echo $item['quantity']; ?>" min="1">
                                                <button type="button" class="btn btn-outline-secondary btn-sm plus-btn">+</button>
                                                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                            </div>
                                        </form>
                                    </td>
                                    <td class="align-middle text-end fw-bold item-total">
                                        <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                    <td class="text-center">
                                        <?php 
                                            $totalQuantity = 0;
                                            foreach ($cart as $item) {
                                                $totalQuantity += $item['quantity'];
                                            }
                                            echo $totalQuantity;
                                        ?>
                                    </td>
                                    <td class="text-end fw-bold text-danger cart-total">
                                        <?php 
                                            $sum = 0;
                                            foreach ($cart as $item) {
                                                $sum += $item['price'] * $item['quantity'];
                                            }
                                            echo number_format($sum, 0, ',', '.'); 
                                        ?> VND
                                    </td>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý nút +/-
    document.querySelectorAll('.minus-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.nextElementSibling;
            if(input.value > 1) {
                input.value--;
                updateItemTotal(this.closest('tr'));
                input.dispatchEvent(new Event('change'));
            }
        });
    });

    document.querySelectorAll('.plus-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            input.value++;
            updateItemTotal(this.closest('tr'));
            input.dispatchEvent(new Event('change'));
        });
    });

    // Xử lý khi thay đổi số lượng thủ công
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            updateItemTotal(this.closest('tr'));
        });
    });

    // Hàm cập nhật thành tiền
    function updateItemTotal(row) {
        const priceText = row.querySelector('.price-item').textContent;
        const price = parseFloat(priceText.replace(/[^\d]/g, ''));
        const quantity = row.querySelector('.quantity-input').value;
        const totalCell = row.querySelector('.item-total');
        const newTotal = price * quantity;
        
        // Cập nhật thành tiền
        totalCell.textContent = newTotal.toLocaleString('vi-VN') + ' VND';
        
        // Cập nhật tổng cộng
        updateGrandTotal();
    }

    // Hàm cập nhật tổng cộng
    function updateGrandTotal() {
        let grandTotal = 0;
        let totalQuantity = 0;
        
        document.querySelectorAll('.item-total').forEach(cell => {
            grandTotal += parseFloat(cell.textContent.replace(/[^\d]/g, ''));
        });
        
        document.querySelectorAll('.quantity-input').forEach(input => {
            totalQuantity += parseInt(input.value);
        });
        
        document.querySelector('.cart-total').textContent = 
            grandTotal.toLocaleString('vi-VN') + ' VND';
            
        // Cập nhật tổng số lượng nếu có phần tử hiển thị
        const totalQtyElement = document.querySelector('tfoot td:nth-child(4)');
        if (totalQtyElement) {
            totalQtyElement.textContent = totalQuantity;
        }
    }
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
