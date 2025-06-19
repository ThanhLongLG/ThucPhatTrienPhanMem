<?php include 'app/views/shares/header.php'; ?>

<!DOCTYPE html> 
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .product-image {
      width: 100%;
      height: 250px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .card:hover .product-image {
      transform: scale(1.05);
    }

    .product-name {
      font-size: 1.25rem;
      font-weight: 600;
      color: #007bff;
      margin-bottom: 0.25rem;
    }

    .product-desc {
      font-size: 0.95rem;
      color: #555;
    }

    .product-price {
      font-size: 1rem;
      font-weight: 600;
      color: #d35400;
    }

    .badge {
      font-size: 0.75rem;
      font-weight: 500;
      padding: 0.3em 0.6em;
      border-radius: 0.4rem;
    }

    .btn-sm i {
      margin-right: 4px;
    }
    a {
    text-decoration: none;
    color: #007bff;
    }

    a:hover {
        text-decoration: underline; /* Nếu bạn vẫn muốn gạch dưới khi hover */
    }
  </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6 text-primary">Danh sách sản phẩm</h1>
            <?php if (SessionHelper::isAdmin()): ?>
                <a href="/TranThanhLong/Product/add" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm sản phẩm mới
                </a>
            <?php endif; ?>
        </div>
        
        <ul class="list-group" id="product-list">
        <!-- Danh sách sản phẩm sẽ được tải từ API và hiển thị tại đây -->
        </ul  
    </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'app/views/shares/footer.php'; ?>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const productList = document.getElementById('product-list');

    // Hàm render sản phẩm
    function renderProduct(product) {
        const productItem = document.createElement('li');
        productItem.className = 'list-group-item';
        productItem.innerHTML = `
            <div class="row">
                <div class="col-md-8">
                    <h2 class="h4">
                        <a href="/TranThanhLong/Product/show/${product.id}">${product.name}</a>
                    </h2>
                    <p class="text-muted">${product.description}</p>
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>Giá:</strong> ${formatCurrency(product.price)}
                            <span class="badge bg-secondary ms-2">${product.category_name}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="btn-group" role="group">
                        <a href="/TranThanhLong/Product/edit/${product.id}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <button class="btn btn-sm btn-danger" onclick="deleteProduct(${product.id})">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </div>
                </div>
            </div>
        `;
        return productItem;
    }

    // Hàm định dạng tiền tệ
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', { 
            style: 'currency', 
            currency: 'VND' 
        }).format(amount);
    }

    // Lấy danh sách sản phẩm
    async function fetchProducts() {
        try {
            const response = await fetch('/TranThanhLong/api/product');
            const products = await response.json();
            
            products.forEach(product => {
                productList.appendChild(renderProduct(product));
            });
        } catch (error) {
            console.error('Lỗi khi tải sản phẩm:', error);
            productList.innerHTML = `
                <div class="alert alert-danger">
                    Không thể tải danh sách sản phẩm. Vui lòng thử lại sau.
                </div>
            `;
        }
    }

    // Xóa sản phẩm
    window.deleteProduct = async function(id) {
        if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) return;

        try {
            const response = await fetch(`/TranThanhLong/api/product/${id}`, {
                method: 'DELETE'
            });
            const data = await response.json();

            if (data.message === 'Product deleted successfully') {
                // Xóa phần tử khỏi DOM thay vì reload trang
                const productItem = document.querySelector(`li:has(button[onclick="deleteProduct(${id})"])`);
                if (productItem) {
                    productItem.remove();
                }
                
                // Thông báo xóa thành công
                showToast('Sản phẩm đã được xóa thành công');
            } else {
                showToast('Xóa sản phẩm thất bại', 'danger');
            }
        } catch (error) {
            console.error('Lỗi khi xóa sản phẩm:', error);
            showToast('Có lỗi xảy ra khi xóa sản phẩm', 'danger');
        }
    }

    // Hàm hiển thị toast thông báo
    function showToast(message, type = 'success') {
        const toastContainer = document.createElement('div');
        toastContainer.innerHTML = `
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div class="toast align-items-center text-white bg-${type} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(toastContainer);
        
        const toast = toastContainer.querySelector('.toast');
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Tự động xóa toast sau khi hiển thị
        setTimeout(() => {
            toastContainer.remove();
        }, 3000);
    }

    // Gọi hàm lấy sản phẩm
    fetchProducts();
});

</script>
