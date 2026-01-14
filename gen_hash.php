<?php
// Generate hash baru untuk password "ibas"
$password = "ibas";
$new_hash = password_hash($password, PASSWORD_BCRYPT);

echo "PASSWORD HASH GENERATOR<br><br>";
echo "Password: <strong>" . $password . "</strong><br>";
echo "Generated Hash:<br>";
echo "<code style='word-break: break-all;'>" . $new_hash . "</code><br><br>";

// Test apakah hash tersebut valid
if (password_verify($password, $new_hash)) {
    echo "<span style='color: green;'><strong>✅ HASH VALID - Password bisa verify!</strong></span><br><br>";
} else {
    echo "<span style='color: red;'><strong>❌ HASH TIDAK VALID</strong></span><br><br>";
}

echo "<strong>Cara menggunakan:</strong><br>";
echo "1. Copy hash di atas<br>";
echo "2. Buka phpmyadmin → tabel users<br>";
echo "3. Edit user 'ibas' → paste hash ke field password<br>";
echo "4. Save / Go<br>";
?>
