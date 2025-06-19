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
            $query = "SELECT p.id, p.name, p.description, p.price, c.name as category_name
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
    

    // Thêm sản phẩm
    public function addProduct($name, $description, $price, $category_id)
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

        

        // Nếu có lỗi, trả về mảng lỗi
        if (count($errors) > 0) {
            return $errors;
        }

        // Chuẩn bị câu truy vấn
        $query = "INSERT INTO " . $this->table_name . " 
                  (name, description, price, category_id) 
                  VALUES (:name, :description, :price, :category_id)";
        
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

    private function uploadImage($imageFile)
    {
        // Kiểm tra lỗi upload
        if ($imageFile['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Kiểm tra loại file
        $allowedTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
        $fileType = mime_content_type($imageFile['tmp_name']);
        
        if (!array_key_exists($fileType, $allowedTypes)) {
            return null;
        }

        // Kiểm tra kích thước file (tối đa 5MB)
        $maxSize = 5 * 1024 * 1024;
        if ($imageFile['size'] > $maxSize) {
            return null;
        }

        // Tạo tên file mới
        $uploadDir = 'public/uploads/products/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = $allowedTypes[$fileType];
        $newFilename = uniqid('product_', true) . '.' . $extension;
        $destination = $uploadDir . $newFilename;

        // Di chuyển file tải lên
        if (move_uploaded_file($imageFile['tmp_name'], $destination)) {
            return $newFilename;
        }

        return null;
    }

// Cập nhật sản phẩm
    public function updateProduct($id, $name, $description, $price, $category_id)
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



        // Nếu có lỗi, trả về mảng lỗi
        if (count($errors) > 0) {
            return $errors;
        }

        // Chuẩn bị câu truy vấn
        $query = "UPDATE " . $this->table_name . " 
                SET name = :name, 
                    description = :description, 
                    price = :price, 
                    category_id = :category_id
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