<!DOCTYPE html>
<html>
<head>
    <title>Danh sách sản phẩm</title>
</head>
<body>
    <h1>Danh sách sản phẩm</h1>
    <a href="/TranThanhLong/Product/add">Thêm sản phẩm mới</a>
    <ul>
        <?php foreach ($products as $product): ?>
        <li>

        <h2><?php echo htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8'); ?></h2>

        <p><?php echo htmlspecialchars($product->getDescription(), ENT_QUOTES,'UTF-8'); ?></p>

        <p>Giá: <?php echo htmlspecialchars($product->getPrice(), ENT_QUOTES,'UTF-8'); ?></p>

        <a href="/TranThanhLong/Product/edit/<?php echo $product->getID();?>">Sửa</a>

        <a href="/TranThanhLong/Product/delete/<?php echo $product->getID(); ?>"onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>

        </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>