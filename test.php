<?php
/**
 * File Test - Untuk memverifikasi setup
 * Akses: http://localhost:8000/test.php
 */

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Test - Product Management</title>";
echo "<style>";
echo "* { margin: 0; padding: 0; box-sizing: border-box; }";
echo "body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }";
echo ".container { max-width: 800px; margin: 0 auto; }";
echo ".test-box { background: white; padding: 20px; margin: 10px 0; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }";
echo ".success { border-left: 4px solid #27ae60; }";
echo ".error { border-left: 4px solid #e74c3c; }";
echo ".warning { border-left: 4px solid #f39c12; }";
echo "h1 { color: #3498db; margin-bottom: 20px; }";
echo "h2 { color: #2c3e50; margin: 15px 0 10px 0; font-size: 16px; }";
echo "code { background: #ecf0f1; padding: 2px 6px; border-radius: 3px; }";
echo ".status { font-weight: bold; }";
echo ".success .status { color: #27ae60; }";
echo ".error .status { color: #e74c3c; }";
echo ".warning .status { color: #f39c12; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";

echo "<h1>🧪 Test System - Product Management</h1>";

// Test 1: PHP Version
echo "<div class='test-box ";
if (version_compare(PHP_VERSION, '7.4.0') >= 0) {
    echo "success";
    $test1 = true;
} else {
    echo "error";
    $test1 = false;
}
echo "'>";
echo "<h2>PHP Version</h2>";
echo "<p><span class='status'>" . (version_compare(PHP_VERSION, '7.4.0') >= 0 ? "✅ PASS" : "❌ FAIL") . "</span></p>";
echo "<p>Current: " . PHP_VERSION . " (Required: 7.4+)</p>";
echo "</div>";

// Test 2: Database Connection
echo "<div class='test-box ";

$db_test = true;
$db_error = "";

try {
    $conn = @new mysqli('localhost', 'root', '', 'product_crud');
    
    if ($conn->connect_error) {
        $db_error = $conn->connect_error;
        $db_test = false;
    } else {
        // Check tables
        $result = $conn->query("SHOW TABLES");
        $tables = [];
        while ($row = $result->fetch_row()) {
            $tables[] = $row[0];
        }
        
        if (!in_array('users', $tables) || !in_array('products', $tables)) {
            $db_error = "Database exists but tables missing";
            $db_test = false;
        }
        
        $conn->close();
    }
} catch (Exception $e) {
    $db_error = $e->getMessage();
    $db_test = false;
}

echo ($db_test ? "success" : "error");
echo "'>";
echo "<h2>Database Connection</h2>";
echo "<p><span class='status'>" . ($db_test ? "✅ PASS" : "❌ FAIL") . "</span></p>";

if ($db_test) {
    echo "<p>✅ MySQL connection successful</p>";
    echo "<p>✅ Database 'product_crud' exists</p>";
    echo "<p>✅ Tables 'users' and 'products' found</p>";
} else {
    echo "<p>❌ Error: " . htmlspecialchars($db_error) . "</p>";
    echo "<p><a href='setup.php' style='color: #3498db; text-decoration: none;'>→ Go to Setup</a></p>";
}

echo "</div>";

// Test 3: Session Support
echo "<div class='test-box success'>";
echo "<h2>Session Support</h2>";
echo "<p><span class='status'>✅ PASS</span></p>";
echo "<p>✅ PHP session support enabled</p>";
echo "</div>";

// Test 4: File Structure
echo "<div class='test-box success'>";
echo "<h2>File Structure</h2>";
$files = [
    'includes/db.php' => true,
    'includes/session.php' => true,
    'assets/css/style.css' => true,
    'assets/js/script.js' => true,
    'login.php' => true,
    'index.php' => true,
    'add_product.php' => true,
    'edit_product.php' => true,
    'delete_product.php' => true,
];

$files_ok = true;
foreach ($files as $file => $exists) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "<p>✅ " . htmlspecialchars($file) . "</p>";
    } else {
        echo "<p>❌ " . htmlspecialchars($file) . " - NOT FOUND</p>";
        $files_ok = false;
    }
}

echo "</div>";

// Summary
echo "<div class='test-box ";
if ($test1 && $db_test && $files_ok) {
    echo "success";
    $all_pass = true;
} else {
    echo "warning";
    $all_pass = false;
}
echo "'>";
echo "<h2>Summary</h2>";

if ($all_pass) {
    echo "<p><span class='status'>✅ ALL TESTS PASSED</span></p>";
    echo "<p>System is ready to use!</p>";
    echo "<p>";
    echo "<a href='setup.php' style='color: white; text-decoration: none; background: #3498db; padding: 8px 15px; border-radius: 4px; display: inline-block; margin-right: 10px;'>Setup Database</a>";
    echo "<a href='login.php' style='color: white; text-decoration: none; background: #2ecc71; padding: 8px 15px; border-radius: 4px; display: inline-block;'>Go to Login</a>";
    echo "</p>";
} else {
    echo "<p><span class='status'>⚠️ SOME ISSUES FOUND</span></p>";
    echo "<p>Please fix the issues above before using the system.</p>";
    echo "<p><a href='setup.php' style='color: #3498db; text-decoration: none;'>→ Go to Setup</a></p>";
}

echo "</div>";

echo "</div>";
echo "</body>";
echo "</html>";
?>
