<?php
$password = "ibas";
$hashed = password_hash($password, PASSWORD_BCRYPT);
echo "Username: ibas<br>";
echo "Password: ibas<br><br>";
echo "Hash untuk di-paste ke phpmyadmin:<br>";
echo "<strong>" . $hashed . "</strong>";
?>