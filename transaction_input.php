<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'includes/db.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$error = '';
$success = '';

// Ambil data produk
$query = "SELECT * FROM products WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $product_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit();
}

$product = $result->fetch_assoc();
$stmt->close();

// Proses input transaksi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jenis_transaksi = isset($_POST['jenis_transaksi']) ? $_POST['jenis_transaksi'] : '';
    $jumlah_barang = isset($_POST['jumlah_barang']) ? (int)$_POST['jumlah_barang'] : 0;
    $keterangan = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : '';
    
    // Validasi
    if (empty($jenis_transaksi) || !in_array($jenis_transaksi, ['masuk', 'keluar'])) {
        $error = 'Jenis transaksi tidak valid!';
    } elseif ($jumlah_barang <= 0) {
        $error = 'Jumlah barang harus lebih dari 0!';
    } else {
        // Mulai transaction
        $conn->begin_transaction();
        
        try {
            // Insert ke tabel transaksi
            $insert_query = "INSERT INTO transaksi (id_barang, jenis_transaksi, jumlah_barang, keterangan) VALUES (?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("isis", $product_id, $jenis_transaksi, $jumlah_barang, $keterangan);
            $insert_stmt->execute();
            
            // Update quantity di products
            if ($jenis_transaksi == 'masuk') {
                $new_quantity = $product['quantity'] + $jumlah_barang;
            } else {
                // Cek stok cukup
                if ($product['quantity'] < $jumlah_barang) {
                    throw new Exception('Stok tidak cukup! Stok tersedia: ' . $product['quantity']);
                }
                $new_quantity = $product['quantity'] - $jumlah_barang;
            }
            
            $update_query = "UPDATE products SET quantity = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ii", $new_quantity, $product_id);
            $update_stmt->execute();
            
            $conn->commit();
            $success = 'Transaksi berhasil dicatat!';
            
            // Refresh data produk
            $query = "SELECT * FROM products WHERE id = ? AND user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $product_id, $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            $stmt->close();
            
        } catch (Exception $e) {
            $conn->rollback();
            $error = $e->getMessage();
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
    <title>Input Transaksi - <?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .transaction-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 32px;
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
        }
        
        .transaction-header {
            margin-bottom: 28px;
            border-bottom: 2px solid var(--border);
            padding-bottom: 20px;
        }
        
        .transaction-header h2 {
            margin: 0 0 8px 0;
            color: var(--dark);
            font-size: 28px;
            font-weight: 700;
        }

        .transaction-header p {
            margin: 0;
            color: var(--text-light);
            font-size: 14px;
        }
        
        .product-info {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 28px;
            border-left: 4px solid var(--primary);
        }
        
        .product-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
        }
        
        .product-info-row:last-child {
            margin-bottom: 0;
        }
        
        .product-info-label {
            font-weight: 600;
            color: var(--text);
        }
        
        .product-info-value {
            color: var(--dark);
            font-weight: 500;
        }
        
        .stock-status {
            font-size: 24px;
            font-weight: 700;
            color: var(--success);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark);
            font-weight: 600;
            font-size: 14px;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            box-sizing: border-box;
            transition: var(--transition);
            background: white;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 32px;
        }
        
        .btn-group button,
        .btn-group a {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: var(--transition);
        }
        
        .btn-submit {
            background: var(--success);
            color: white;
        }
        
        .btn-submit:hover {
            background: var(--success-dark);
            transform: translateY(-2px);
        }
        
        .btn-cancel {
            background: var(--text-light);
            color: white;
        }
        
        .btn-cancel:hover {
            background: var(--text);
            transform: translateY(-2px);
        }
        
        .success-msg {
            background: #f0fdf4;
            color: #166534;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid var(--success);
            font-size: 14px;
        }
        
        .error-msg {
            background: #fef2f2;
            color: #991b1b;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid var(--danger);
            font-size: 14px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <h1>📦 Product Manager</h1>
            </div>
            <div class="navbar-menu">
                <span class="user-info">Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
                <a href="profile.php" class="btn btn-primary">👤 Profil</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="transaction-container">
        <div class="transaction-header">
            <h2>📝 Input Transaksi</h2>
            <p style="margin: 0; color: #999; font-size: 14px;">Catat masuk/keluarnya stok barang</p>
        </div>

        <div class="product-info">
            <div class="product-info-row">
                <span class="product-info-label">Nama Barang:</span>
                <span class="product-info-value"><?php echo htmlspecialchars($product['name']); ?></span>
            </div>
            <div class="product-info-row">
                <span class="product-info-label">Harga/Unit:</span>
                <span class="product-info-value">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></span>
            </div>
            <div class="product-info-row">
                <span class="product-info-label">Stok Saat Ini:</span>
                <span class="product-info-value stock-status"><?php echo $product['quantity']; ?> unit</span>
            </div>
        </div>

        <?php if (!empty($success)): ?>
            <div class="success-msg">✓ <?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="error-msg">✗ <?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="jenis_transaksi">Jenis Transaksi</label>
                <select id="jenis_transaksi" name="jenis_transaksi" required>
                    <option value="">-- Pilih --</option>
                    <option value="masuk">📥 Barang Masuk (Pembelian/Penerimaan)</option>
                    <option value="keluar">📤 Barang Keluar (Penjualan/Pengiriman)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="jumlah_barang">Jumlah Barang (Unit)</label>
                <input type="number" id="jumlah_barang" name="jumlah_barang" 
                       min="1" required placeholder="Contoh: 10">
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan (Opsional)</label>
                <textarea id="keterangan" name="keterangan" 
                          placeholder="Contoh: Pembelian dari supplier ABC, atau Penjualan ke customer XYZ"></textarea>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-submit">Simpan Transaksi</button>
                <a href="index.php" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
