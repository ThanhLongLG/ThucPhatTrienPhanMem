<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";
    public function __construct($db)
        {
            $this->conn = $db;
        }
        public function getProducts()
        {
            $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name
                      FROM " . $this->table_name . " p
                      LEFT JOIN category c ON p.category_id = c.id
                      ORDER BY p.id DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }

    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
   
    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
   // Phương thức upload ảnh
    private function uploadImage($image)
    {
        // Kiểm tra xem có file ảnh được upload không
        if (!$image || $image['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Thư mục lưu trữ ảnh
        $uploadDir = 'public/uploads/products/';
        
        // Tạo thư mục nếu chưa tồn tại
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Tạo tên file duy nhất
        $fileExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $fileExtension;
        $uploadPath = $uploadDir . $fileName;

        // Kiểm tra và giới hạn kích thước ảnh
        $maxFileSize = 5 * 1024 * 1024; // 5MB
        if ($image['size'] > $maxFileSize) {
            return null;
        }

        // Các loại file được phép
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($image['tmp_name']);
        if (!in_array($fileType, $allowedTypes)) {
            return null;
        }

        // Di chuyển file
        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            return $fileName;
        }

        return null;
    }

    // Thêm sản phẩm
    public function addProduct($name, $description, $price, $category_id, $image = null)
    {
        $errors = [];
        
        // Validation
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        } elseif (strlen($name) < 10 || strlen($name) > 100) {
            $errors['name'] = 'Tên sản phẩm phải từ 10 đến 100 ký tự';
        }

        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }

        if (!is_numeric($price) || $price <= 0) {
            $errors['price'] = 'Giá sản phẩm phải là số dương';
        }

        if (empty($category_id)) {
            $errors['category_id'] = 'Danh mục không được để trống';
        }

        // Upload ảnh nếu có
        $imageFileName = null;
        if ($image && $image['size'] > 0) {
            $imageFileName = $this->uploadImage($image);
            if ($imageFileName === null) {
                $errors['image'] = 'Ảnh không hợp lệ. Vui lòng chọn ảnh khác.';
            }
        }

        // Nếu có lỗi, trả về mảng lỗi
        if (count($errors) > 0) {
            return $errors;
        }

        // Chuẩn bị câu truy vấn
        $query = "INSERT INTO " . $this->table_name . " 
                  (name, description, price, category_id, image) 
                  VALUES (:name, :description, :price, :category_id, :image)";
        
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = floatval($price);
        $category_id = intval($category_id);

        // Bind các tham số
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $imageFileName);

        // Thực thi và trả về kết quả
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $e) {
            // Ghi log lỗi nếu cần
            error_log("Lỗi thêm sản phẩm: " . $e->getMessage());
        }
        
        return false;
    }

    public function getProductImageById($id)
{
    $query = "SELECT image FROM " . $this->table_name . " WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['image'] : null;
}

// Cập nhật sản phẩm
public function updateProduct($id, $name, $description, $price, $category_id, $image = null, $oldImage = null)
{
    $errors = [];
    
    // Validation
    if (empty($name)) {
        $errors['name'] = 'Tên sản phẩm không được để trống';
    } elseif (strlen($name) < 10 || strlen($name) > 100) {
        $errors['name'] = 'Tên sản phẩm phải từ 10 đến 100 ký tự';
    }

    if (empty($description)) {
        $errors['description'] = 'Mô tả không được để trống';
    }

    if (!is_numeric($price) || $price <= 0) {
        $errors['price'] = 'Giá sản phẩm phải là số dương';
    }

    if (empty($category_id)) {
        $errors['category_id'] = 'Danh mục không được để trống';
    }

    // Xử lý upload ảnh mới
    $imageFileName = $oldImage;
    if ($image && $image['size'] > 0) {
        $newImageFileName = $this->uploadImage($image);
        if ($newImageFileName === null) {
            $errors['image'] = 'Ảnh không hợp lệ. Vui lòng chọn ảnh khác.';
        } else {
            // Xóa ảnh cũ nếu có
            if ($oldImage) {
                $oldImagePath = 'public/uploads/products/' . $oldImage;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $imageFileName = $newImageFileName;
        }
    }

    // Nếu có lỗi, trả về mảng lỗi
    if (count($errors) > 0) {
        return $errors;
    }

    // Chuẩn bị câu truy vấn
    $query = "UPDATE " . $this->table_name . " 
              SET name = :name, 
                  description = :description, 
                  price = :price, 
                  category_id = :category_id, 
                  image = :image 
              WHERE id = :id";
    
    $stmt = $this->conn->prepare($query);
    
    // Làm sạch dữ liệu
    $name = htmlspecialchars(strip_tags($name));
    $description = htmlspecialchars(strip_tags($description));
    $price = floatval($price);
    $category_id = intval($category_id);
    $id = intval($id);

    // Bind các tham số
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':image', $imageFileName);

    // Thực thi và trả về kết quả
    try {
        if ($stmt->execute()) {
            return true;
        }
    } catch (PDOException $e) {
        // Ghi log lỗi nếu cần
        error_log("Lỗi cập nhật sản phẩm: " . $e->getMessage());
    }
    
    return false;
}
}
?>