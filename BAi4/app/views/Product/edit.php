<?php include 'app/views/shares/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-edit"></i> Sửa sản phẩm</h3>
                    </div>
                    
                    <div class="card-body">
                        <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <form method="POST" action="/TranThanhLong/Product/update" enctype="multipart/form-data"
                        onsubmit="return validateForm();">
                            <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                            <div class="mb-3">
                                
                                <label for="name" class="form-label">Tên sản phẩm</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
                                       required 
                                       placeholder="Nhập tên sản phẩm">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" 
                                          required rows="3"
                                          placeholder="Nhập mô tả chi tiết"><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="price" class="form-label">Giá</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="price" name="price" 
                                           value="<?php echo htmlspecialchars($product->Price, ENT_QUOTES, 'UTF-8'); ?>"
                                           required 
                                           step="0.01"
                                           placeholder="Nhập giá sản phẩm">
                                    <span class="input-group-text">VND</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="category_id">Danh mục:</label>
                                <select id="category_id" name="category_id" class="form-control" required>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category->id; ?>" <?php echo $category->id
                                    == $product->category_id ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8');
                                    ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>  
                            </div>
                                <div class="mb-4"><label for="image" class="form-label">Ảnh sản phẩm</label>
                                <div class="mb-2">
                                    <?php if (!empty($product->image)): ?>
                                        <img src="/TranThanhLong/Product/displayImage/<?php echo $product->image; ?>" 
                                            alt="Ảnh sản phẩm" 
                                            class="img-thumbnail" 
                                            style="max-width: 200px; max-height: 200px;">
                                    <?php endif; ?>
                                </div>
                                <input type="file" 
                                    class="form-control" 
                                    id="image" 
                                    name="image" 
                                    accept="image/jpeg,image/png,image/gif">
                                <small class="text-muted">Chỉ chấp nhận file ảnh (jpg, png, gif). Tối đa 5MB.</small>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="/TranThanhLong/Product/list" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include 'app/views/shares/footer.php'; ?>
