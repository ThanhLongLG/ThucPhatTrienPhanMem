<?php include 'app/views/shares/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        function validateForm() {
            let name = document.getElementById('name').value;
            let price = document.getElementById('price').value;
            let image = document.getElementById('image').files[0];
            let errors = [];
            
            if (name.length < 10 || name.length > 100) {
                errors.push('Tên sản phẩm phải có từ 10 đến 100 ký tự.');
            }
            if (price <= 0 || isNaN(price)) {
                errors.push('Giá phải là một số dương lớn hơn 0.');
            }
            
            // Kiểm tra ảnh
            if (image) {
                let allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(image.type)) {
                    errors.push('Chỉ chấp nhận file ảnh JPG, PNG hoặc GIF.');
                }
                
                // Kiểm tra kích thước file (5MB)
                if (image.size > 5 * 1024 * 1024) {
                    errors.push('Kích thước ảnh không được vượt quá 5MB.');
                }
            }
            
            if (errors.length > 0) {
                alert(errors.join('\n'));
                return false;
            }
            return true;
        }

        // Xem trước ảnh
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const file = input.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-plus-circle"></i> Thêm sản phẩm mới</h3>
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

                        <form method="POST" action="/TranThanhLong/Product/save" enctype="multipart/form-data"
                        onsubmit="return validateForm()">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên sản phẩm</label>
                                <input type="text" class="form-control" id="name" name="name" required 
                                       placeholder="Nhập tên sản phẩm (10-100 ký tự)"
                                       value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" required 
                                          rows="3" placeholder="Nhập mô tả chi tiết"><?php 
                                          echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; 
                                          ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Giá</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="price" name="price" 
                                           step="0.01" required placeholder="Nhập giá sản phẩm"
                                           value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>">
                                    <span class="input-group-text">VND</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Danh mục</label>
                                <select id="category_id" name="category_id" class="form-control" required>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category->id; ?>" 
                                        <?php echo (isset($_POST['category_id']) && $_POST['category_id'] == $category->id) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Ảnh sản phẩm</label>
                                <input type="file" class="form-control" id="image" name="image" 
                                       accept="image/jpeg,image/png,image/gif"
                                       onchange="previewImage(this)">
                                <small class="form-text text-muted">
                                    Chỉ chấp nhận file ảnh JPG, PNG, GIF (tối đa 5MB)
                                </small>
                            </div>

                            <div class="mb-3 text-center">
                                <img id="image-preview" src="" alt="Xem trước ảnh" 
                                     style="display:none; max-width: 300px; max-height: 300px;">
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="/TranThanhLong/Product/Index" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Thêm sản phẩm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include 'app/views/shares/footer.php'; ?>
