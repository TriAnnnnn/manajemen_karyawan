<?php
// Ganti 'admin123' dengan password yang Anda inginkan
$password = 'sultan1234';
echo password_hash($password, PASSWORD_DEFAULT);