<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'includes/db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_password = isset($_POST['old_password']) ? $_POST['old_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    
    // Validasi input
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $error = 'Semua field harus diisi!';
    } elseif (strlen($new_password) < 6) {
        $error = 'Password baru harus minimal 6 karakter!';
    } elseif ($new_password !== $confirm_password) {
        $error = 'Password baru dan konfirmasi tidak cocok!';
    } else {
        // Ambil password lama dari database
        $query = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            
            // Verifikasi password lama
            if (password_verify($old_password, $user['password'])) {
                // Update password baru
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $update_query = "UPDATE users SET password = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                
                if ($update_stmt) {
                    $update_stmt->bind_param("si", $hashed_password, $_SESSION['user_id']);
                    
                    if ($update_stmt->execute()) {
                        $success = 'Password berhasil diubah! Silakan login kembali.';
                        // Logout user setelah sukses
                        session_destroy();
                        header("Refresh: 3; url=login.php");
                    } else {
                        $error = 'Gagal mengubah password!';
                    }
                    
                    $update_stmt->close();
                }
            } else {
                $error = 'Password lama tidak sesuai!';
            }
            
            $stmt->close();
        }
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .change-password-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .change-password-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .form-group input:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn-secondary {
            background-color: #666;
            margin-top: 10px;
        }
        .btn-secondary:hover {
            background-color: #555;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 3px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 3px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #4CAF50;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="change-password-container">
        <h2>Ubah Password</h2>
        
        <?php if (!empty($success)): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (empty($success)): ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="old_password">Password Lama:</label>
                    <input type="password" id="old_password" name="old_password" required>
                </div>
                
                <div class="form-group">
                    <label for="new_password">Password Baru:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password Baru:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="btn">Ubah Password</button>
                <a href="index.php"><button type="button" class="btn btn-secondary">Batal</button></a>
            </form>
        <?php endif; ?>
        
        <div class="back-link">
            <a href="index.php">← Kembali ke beranda</a>
        </div>
    </div>
</body>
</html>
