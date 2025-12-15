<?php
require_once 'php/config.php';
session_destroy();
header('Location: index.php?success=Anda berhasil logout');
exit;
?>