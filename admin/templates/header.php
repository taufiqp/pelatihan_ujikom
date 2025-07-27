<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

// Jika belum login, tendang ke halaman login
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Aplikasi Koperasi</title>
    <link href="<?= BASE_URL ?>/admin/assets/css/bootstrap.min.css" rel="stylesheet">
    <style> .sidebar { min-height: 100vh; } </style>
</head>
<body>
<div class="d-flex">