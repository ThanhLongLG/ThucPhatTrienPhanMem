<?php include 'app/views/shares/header.php'; ?>

<!DOCTYPE html> 
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .card:hover .product-image {
            transform: scale(1.05);
        }
        .card-img-top {
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6 text-primary">Danh sách sản phẩm</h1>
            <a href="/TranThanhLong/Product/add" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm sản phẩm mới
            </a>
        </div>

        <?php if (empty($products)): ?>
        <div class="alert alert-info text-center" role="alert">
            Không có sản phẩm nào để hiển thị.
        </div>
        <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <?php 
                    // Đường dẫn mặc định nếu không có ảnh
                    $imagePath = $product->image 
                        ? '/public/uploads/products/' . htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8') 
                        : '/public/uploads/default-product.png'; 
                    ?>
                    <img src="<?php echo $imagePath; ?>" 
                         class="card-img-top product-image" 
                         alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                         onerror="this.src='/public/uploads/default-product.png';">
                    
                    <div class="card-body">
                        <h2 class="card-title h5"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h2>
                        <p class="card-text text-muted">
                            <?php 
                            // Giới hạn độ dài mô tả
                            $description = htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8');
                            echo strlen($description) > 100 ? substr($description, 0, 100) . '...' : $description; 
                            ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-danger fw-bold mb-0">
                                Giá: <?php echo number_format($product->price, 0, ',', '.') ?> VND
                            </p>
                            <small class="text-muted">
                                <i class="fas fa-tag"></i> 
                                <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                            </small>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <div class="d-grid gap-2 d-md-block text-center">
                            <a href="/TranThanhLong/Product/view/<?php echo $product->id; ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Chi tiết
                            </a>
                            <a href="/TranThanhLong/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <a href="/TranThanhLong/Product/delete/<?php echo $product->id; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'app/views/shares/footer.php'; ?>
