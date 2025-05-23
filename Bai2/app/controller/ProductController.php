<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $image = $_FILES['image'] ?? null;

            $result = $this->productModel->addProduct(
                $name, 
                $description, 
                $price, 
                $category_id, 
                $image
            );

            if (is_array($result)) {
                // Nếu có lỗi
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                // Thành công
                header('Location: /TranThanhLong/Product');
                exit();
            }
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            
            // Lấy ảnh cũ để so sánh
            $oldImage = $this->productModel->getProductImageById($id);
            
            // Xử lý upload ảnh mới
            $image = $_FILES['image'] ?? null;

            $edit = $this->productModel->updateProduct(
                $id, 
                $name, 
                $description, 
                $price, 
                $category_id, 
                $image,
                $oldImage
            );

            if ($edit) {
                header('Location: /TranThanhLong/Product');
                exit();
            } else {
                // Có thể thêm thông báo lỗi chi tiết hơn
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        // Lấy thông tin ảnh trước khi xóa
        $image = $this->productModel->getProductImageById($id);

        if ($this->productModel->deleteProduct($id)) {
            // Nếu có ảnh, xóa file ảnh
            if ($image) {
                $imagePath = 'public/uploads/products/' . $image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            header('Location: /TranThanhLong/Product');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    // Phương thức để hiển thị ảnh sản phẩm
    public function displayImage($filename)
    {
        $imagePath = 'public/uploads/products/' . $filename;
        
        if (file_exists($imagePath)) {
            $fileInfo = pathinfo($imagePath);
            $mimeTypes = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif'
            ];

            $ext = strtolower($fileInfo['extension']);
            $mimeType = $mimeTypes[$ext] ?? 'application/octet-stream';

            header('Content-Type: ' . $mimeType);
            readfile($imagePath);
        } else {
            // Ảnh mặc định hoặc thông báo lỗi
            header("HTTP/1.0 404 Not Found");
            echo "Ảnh không tồn tại";
        }
        exit();
    }
}
?>
