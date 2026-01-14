<?php
// Test password verification
$password_input = "ibas";
$hash_from_db = '$2y$10$EvjL8Pt9ShHKnmIpHKGBmOJrNpd0Jm6UWDZbwh6PLdGkB9wPPFEpi';

echo "Password yang diinput: " . $password_input . "<br>";
echo "Hash di database: " . $hash_from_db . "<br><br>";

if (password_verify($password_input, $hash_from_db)) {
    echo "<span style='color: green;'><strong>✅ PASSWORD COCOK!</strong></span>";
} else {
    echo "<span style='color: red;'><strong>❌ PASSWORD TIDAK COCOK!</strong></span>";
}
?>
