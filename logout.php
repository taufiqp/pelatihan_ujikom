<?php
session_start();
require 'admin/config/database.php';
session_unset();
session_destroy();
header('Location: ' . BASE_URL . '/login.php?logout=1');
exit();
?>