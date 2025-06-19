<?php
    require_once('app/config/database.php');
    require_once('app/models/ProductModel.php');
    require_once('app/models/CategoryModel.php');
    class ProductApiController
    {
        private $productModel;
        private $db;
        public function __construct()
        {
            $this->db = (new Database())->getConnection();
            $this->productModel = new ProductModel($this->db);
        }
        // Lấy danh sách sản phẩm
        public function index()
        {
            header('Content-Type: application/json');
            $products = $this->productModel->getProducts();
            echo json_encode($products);
        }
    // Lấy thông tin sản phẩm theo ID
        public function show($id)
        {
            header('Content-Type: application/json');
            $product = $this->productModel->getProductById($id);
            if ($product) {
                echo json_encode($product);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Product not found']);
            }
        }
    // Thêm sản phẩm mới
        public function store()
        {
            header('Content-Type: application/json');
            $data = json_decode(file_get_contents("php://input"), true);
            $name = $data['name'] ?? '';
            $description = $data['description'] ?? '';
            $price = $data['price'] ?? '';
            $category_id = $data['category_id'] ?? null;
            $result = $this->productModel->addProduct($name, $description, $price,
            $category_id, null);
            if (is_array($result)) {
                http_response_code(400);
                echo json_encode(['errors' => $result]);
            } else {
                http_response_code(201);
                echo json_encode(['message' => 'Product created successfully']);
            }
        }
// Cập nhật sản phẩm theo ID
        public function update($id) {
            header('Content-Type: application/json');
            
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $this->productModel->updateProduct(
                $id,
                $data['name'] ?? '',
                $data['description'] ?? '',
                $data['price'] ?? '',
                $data['category_id'] ?? null
            );

            // Xử lý response hợp lý
            if (is_array($result)) { // Nếu có lỗi validation
                http_response_code(422); // Unprocessable Entity
                echo json_encode(['errors' => $result]);
                return; // Quan trọng: dừng xử lý ngay
            }

            if ($result === true) {
                echo json_encode(['message' => 'Product updated successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Update failed']);
            }
        }
// Xóa sản phẩm theo ID
        public function destroy($id)
        {
            header('Content-Type: application/json');
            $result = $this->productModel->deleteProduct($id);
            if ($result) {
                echo json_encode(['message' => 'Product deleted successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Product deletion failed']);
            }
        }
    }
?>