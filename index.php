<?php
require 'includes/session.php';
require 'includes/db.php';

$message = '';
$message_type = '';

// Ambil data produk
$query = "SELECT * FROM products WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

$stmt->close();

// Cek pesan dari delete
if (isset($_GET['deleted'])) {
    $message = 'Produk berhasil dihapus!';
    $message_type = 'success';
}

if (isset($_GET['error'])) {
    $message = 'Gagal menghapus produk!';
    $message_type = 'danger';
}

$conn->close();

// Hitung statistik
$total_products = count($products);
$total_quantity = 0;
$total_value = 0;

foreach ($products as $product) {
    $total_quantity += $product['quantity'];
    $total_value += $product['price'] * $product['quantity'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Product Management</title>
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
                <a href="change_password.php" class="btn btn-info">🔐 Ubah Password</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="header-section">
            <h2>Dashboard Produk</h2>
            <a href="add_product.php" class="btn btn-success">+ Tambah Produk</a>
        </div>

        <div class="stats-container">
            <div class="stat-box">
                <h3><?php echo $total_products; ?></h3>
                <p>Total Produk</p>
            </div>
            <div class="stat-box">
                <h3><?php echo $total_quantity; ?></h3>
                <p>Total Quantity</p>
            </div>
            <div class="stat-box">
                <h3>Rp <?php echo number_format($total_value, 0, ',', '.'); ?></h3>
                <p>Total Nilai</p>
            </div>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($products)): ?>
            <div class="no-data">
                <p>Belum ada produk. <a href="add_product.php">Tambah produk sekarang</a></p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $index => $product): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td>Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></td>
                                <td>
                                    <span class="quantity-badge">
                                        <?php echo $product['quantity']; ?>
                                    </span>
                                </td>
                                <td>Rp <?php echo number_format($product['price'] * $product['quantity'], 0, ',', '.'); ?></td>
                                <td><?php echo htmlspecialchars(substr($product['description'], 0, 30)); ?></td>
                                <td class="action-buttons">
                                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                    <a href="javascript:void(0);" onclick="deleteProduct(<?php echo $product['id']; ?>)" class="btn btn-sm btn-danger">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
