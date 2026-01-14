<?php
require 'includes/session.php';
require 'includes/db.php';

$product = null;
$error = '';
$success = '';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id === 0) {
    header("Location: index.php");
    exit();
}

// Ambil data produk
$query = "SELECT * FROM products WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit();
}

$product = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
    
    // Validasi
    if (empty($name)) {
        $error = 'Nama produk harus diisi!';
    } elseif ($price <= 0) {
        $error = 'Harga harus lebih besar dari 0!';
    } elseif ($quantity < 1) {
        $error = 'Quantity harus minimal 1!';
    } else {
        $query = "UPDATE products SET name = ?, description = ?, price = ?, quantity = ? 
                  WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param("ssdii", $name, $description, $price, $quantity, $id, $_SESSION['user_id']);
            
            if ($stmt->execute()) {
                $success = 'Produk berhasil diperbarui!';
                $product['name'] = $name;
                $product['description'] = $description;
                $product['price'] = $price;
                $product['quantity'] = $quantity;
            } else {
                $error = 'Gagal memperbarui produk!';
            }
            
            $stmt->close();
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Product Management</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <h1>📦 Product Manager</h1>
            </div>
            <div class="navbar-menu">
                <span class="user-info">Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <h2>Edit Produk</h2>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="" class="form">
                <div class="form-group">
                    <label for="name">Nama Produk <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" 
                           placeholder="Masukkan nama produk" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control" 
                              rows="4" placeholder="Masukkan deskripsi produk"><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Harga <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="currency">Rp</span>
                            <input type="number" id="price" name="price" class="form-control" 
                                   placeholder="0" min="1" step="0.01" value="<?php echo $product['price']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="quantity">Quantity <span class="required">*</span></label>
                        <input type="number" id="quantity" name="quantity" class="form-control" 
                               placeholder="0" min="1" value="<?php echo $product['quantity']; ?>" required>
                        <small class="text-muted">Minimal 1</small>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Perbarui Produk</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
