<?php
// Bagian PHP - Pengamanan Sesi Login dan Data Pengguna
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

// Ambil data dari session
$user_email = $_SESSION['user_email'] ?? 'user@dipsol.com';
$user_role = $_SESSION['user_role'] ?? 'Admin';

// Data simulasi untuk tabel SOP
$sop_data = [
    [
        'kode' => 'SOP 1',
        'nama' => 'Pembersihan',
        'departemen' => 'Production',
        'status' => 'Draft',
        'versi' => '1.0',
        'last_update' => '11/14/2025'
    ],
    [
        'kode' => 'SOP-2024-001',
        'nama' => 'Standard Operating Procedure - Production',
        'departemen' => 'Production',
        'status' => 'Active',
        'versi' => '1.0',
        'last_update' => '11/14/2025'
    ],
    // Tambahkan data lain jika diperlukan
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOP Management - PT Dipsol Indonesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* CSS Umum - Modern Navbar Design */
        :root {
            --primary-color: #004d99; /* Biru gelap untuk header & menu aktif */
            --sidebar-width: 260px;
            --header-height: 70px;
            --text-color: #333;
            --secondary-text: #666;
            --bg-light: #f4f7f9; /* Latar belakang body */
            --card-bg: white;
            --draft-color: #ffc107; /* Kuning untuk status Draft */
            --active-color: #28a745; /* Hijau untuk status Active */
            --border-color: #e8eef3;
            --hover-color: #f8fafc;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-light);
            display: flex;
            min-height: 100vh;
            color: var(--text-color);
            overflow-x: hidden;
        }

        /* Modern Sidebar (Menu Samping) */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-md);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            transition: var(--transition);
            border-right: 1px solid var(--border-color);
        }

        .sidebar-header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            min-height: var(--header-height);
            background: linear-gradient(135deg, var(--primary-color) 0%, #0066cc 100%);
            color: white;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            font-size: 1.3em;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }

        .sidebar-logo span {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            margin-right: 12px;
            font-weight: 800;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar-close {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            font-size: 1.2em;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-close:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        .sidebar-nav {
            flex-grow: 1;
            padding: 20px 0;
            overflow-y: auto;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 14px 24px;
            text-decoration: none;
            color: var(--secondary-text);
            font-weight: 500;
            transition: var(--transition);
            margin: 2px 12px;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-nav a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--primary-color);
            transform: translateX(-100%);
            transition: var(--transition);
            border-radius: 0 4px 4px 0;
        }

        .sidebar-nav a i {
            margin-right: 16px;
            width: 20px;
            text-align: center;
            font-size: 1.1em;
        }

        .sidebar-nav a:hover {
            background-color: var(--hover-color);
            color: var(--primary-color);
            transform: translateX(4px);
        }

        .sidebar-nav a:hover::before {
            transform: translateX(0);
        }

        .sidebar-nav a.active {
            background: linear-gradient(135deg, #e6f0ff 0%, #f0f7ff 100%);
            color: var(--primary-color);
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }

        .sidebar-nav a.active::before {
            transform: translateX(0);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--border-color);
            background: rgba(248, 250, 252, 0.8);
        }
        
        .sidebar-footer a {
            color: var(--secondary-text);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 16px;
            font-weight: 500;
            border-radius: 8px;
            transition: var(--transition);
        }

        .sidebar-footer a i {
            margin-right: 12px;
            color: #dc3545;
        }
        
        .sidebar-footer a:hover {
            background-color: #fff5f5;
            color: #dc3545;
            transform: translateX(4px);
        }

        /* Konten Utama */
        .main-content {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
        }

        /* Modern Header (Top Bar) */
        .header-bar {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            height: var(--header-height);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            box-shadow: var(--shadow-sm);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-title {
            font-size: 1.6em;
            font-weight: 600;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: linear-gradient(180deg, var(--primary-color), #0066cc);
            border-radius: 2px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-btn {
            position: relative;
            background: var(--hover-color);
            border: 1px solid var(--border-color);
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .notification-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #dc3545;
            color: white;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            font-size: 0.7em;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        .user-details {
            text-align: right;
            line-height: 1.3;
            font-size: 0.9em;
            padding: 8px 12px;
            background: var(--hover-color);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .user-details strong {
            display: block;
            font-weight: 600;
            color: var(--text-color);
        }

        .user-details small {
            color: var(--secondary-text);
        }

        /* Mobile menu toggle button */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: var(--primary-color);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: var(--shadow-md);
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .header-bar {
                padding: 0 20px;
            }

            .header-title {
                font-size: 1.3em;
            }

            .user-details {
                display: none;
            }

            .page-content {
                padding: 15px;
            }

            .sidebar-nav a {
                padding: 16px 20px;
            }

            .sidebar-header {
                padding: 15px 20px;
            }

            .notification-btn {
                width: 38px;
                height: 38px;
            }
        }

        @media (max-width: 480px) {
            .header-title {
                font-size: 1.1em;
            }

            .sidebar {
                width: 100%;
            }
        }
        
        /* Konten SOP Management */
        .page-content {
            padding: 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .page-header h1 {
            font-size: 2em;
            font-weight: 700;
            margin: 0;
        }

        /* --- BUTTON STYLES --- */
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: background-color 0.2s;
        }
        
        .btn-primary:hover {
            background-color: #003366;
        }
        
        .btn-primary i {
            margin-right: 8px;
        }
        
        .btn-secondary {
            background-color: #f0f0f0;
            color: var(--text-color);
            padding: 10px 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }

        /* Filter dan Search Bar */
        .filter-controls {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-group {
            display: flex;
            flex-grow: 1;
            margin-right: 20px;
            max-width: 600px;
            background-color: var(--bg-light);
            border-radius: 6px;
            align-items: center;
            padding: 8px 15px;
            border: 1px solid #ddd;
        }
        
        .search-group input {
            border: none;
            outline: none;
            background: transparent;
            flex-grow: 1;
            font-size: 1em;
            padding: 0 10px;
        }
        
        .search-group i {
            color: var(--secondary-text);
        }

        .select-filter {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: white;
            color: var(--text-color);
            font-weight: 500;
            appearance: none; /* Hilangkan default style select */
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23333" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 30px;
            cursor: pointer;
        }

        /* Tabel Data */
        .data-table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th, .data-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 0.9em;
        }

        .data-table th {
            background-color: #f7f9fb;
            color: var(--secondary-text);
            font-weight: 500;
        }

        /* Kolom Action */
        .data-table td.action-cell i {
            margin: 0 8px;
            cursor: pointer;
            color: var(--secondary-text);
            transition: color 0.2s;
        }
        
        .data-table td.action-cell i:hover {
            color: var(--primary-color);
        }

        /* Badge Status */
        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 0.8em;
            display: inline-block;
        }

        .status-badge.draft {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .status-badge.active {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        /* Built With */
        .built-with {
            position: fixed;
            bottom: 15px;
            right: 15px;
            background-color: #333;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.8em;
            font-weight: 500;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 90; /* Posisikan di bawah modal */
        }
        
        .built-with span {
            margin-right: 5px;
        }

        /* ================================== */
        /* --- MODAL (POPUP) STYLES --- */
        /* ================================== */

        /* Overlay untuk menutupi layar */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none; /* Default tersembunyi */
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        /* Konten Modal */
        .modal-content {
            background-color: white;
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transform: scale(0.9);
            transition: transform 0.3s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .modal-overlay.active .modal-content {
             transform: scale(1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }

        .modal-header h2 {
            font-size: 1.25em;
            font-weight: 700;
            margin: 0;
            color: var(--primary-color);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5em;
            color: var(--secondary-text);
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .modal-close:hover {
            color: #333;
        }

        .modal-body {
            padding: 20px;
            overflow-y: auto;
            flex: 1;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 0.95em;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1em;
            background-color: var(--bg-light);
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary-color);
            outline: none;
            background-color: white;
        }
        
        .form-group select {
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23333" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 40px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-col {
            flex: 1;
        }
        
        /* Tambahan untuk PIN (Opsional) */
        .pin-hint {
            font-size: 0.75em;
            color: var(--secondary-text);
            margin-top: 5px;
        }

        /* Style untuk Instruksi SOP */
        .instruction-item {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #fafafa;
            position: relative;
        }

        .instruction-image-container {
            flex: 0 0 120px;
            height: 120px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            background-color: #f9f9f9;
        }

        .instruction-image-container:hover {
            border-color: var(--primary-color);
            background-color: #f0f7ff;
        }

        .instruction-image-container input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .instruction-image-container i {
            font-size: 2em;
            color: #ccc;
            margin-bottom: 5px;
        }

        .instruction-image-container span {
            font-size: 0.8em;
            color: #999;
            text-align: center;
        }

        .instruction-image-container.has-image {
            border-style: solid;
            border-color: var(--primary-color);
        }

        .instruction-image-container.has-image i,
        .instruction-image-container.has-image span {
            display: none;
        }

        .instruction-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .instruction-image-container.has-image img {
            display: block;
        }

        .instruction-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .instruction-number {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
            font-size: 0.9em;
        }

        .instruction-text {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            resize: vertical;
            min-height: 80px;
            font-family: inherit;
            font-size: 0.95em;
            box-sizing: border-box;
            background-color: white;
            transition: border-color 0.2s;
        }

        .instruction-text:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .instruction-remove {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            font-size: 0.8em;
            transition: background-color 0.2s;
            z-index: 10;
        }

        .instruction-remove:hover {
            background: #cc0000;
        }

        .empty-instructions {
            text-align: center;
            padding: 20px;
            color: #999;
            font-style: italic;
            border: 1px dashed #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .validation-message {
            color: #e74c3c;
            font-size: 0.85em;
            margin-top: 5px;
            display: none;
        }

        .instruction-text.error {
            border-color: #e74c3c;
        }

        .btn-add-instruction {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px;
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 6px;
            color: #6c757d;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-add-instruction:hover {
            background-color: #e9ecef;
            border-color: #adb5bd;
            color: #495057;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            padding: 15px 20px;
            border-top: 1px solid #eee;
            gap: 10px;
        }
        
        /* Media Query untuk Mobile */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-var(--sidebar-width));
                transition: transform 0.3s ease;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-header .sidebar-close {
                display: block;
            }
            .header-bar .sidebar-toggle {
                display: block;
                margin-right: 15px;
            }
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .page-header .btn-primary {
                margin-top: 10px;
                width: 100%;
                justify-content: center;
            }
            .filter-controls {
                flex-direction: column;
                align-items: stretch;
            }
            .search-group {
                margin-right: 0;
                margin-bottom: 10px;
                max-width: 100%;
            }
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            .modal-content {
                max-width: 95%;
                max-height: 95vh;
            }
            
            .instruction-item {
                flex-direction: column;
            }
            
            .instruction-image-container {
                flex: 0 0 auto;
                width: 100%;
                height: 150px;
                align-self: center;
            }
        }
    </style>
</head>
<body>
    <button class="mobile-menu-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar">
       <div class="sidebar-header">
            <a href="dashboard.php" class="sidebar-logo">
                <span>PT. DIPSOL INDONESIA</span>
            </a>
            <!-- <button class="sidebar-close" onclick="toggleSidebar()">
                <i class="fas fa-times"></i>
            </button> -->
        </div>
        
        <nav class="sidebar-nav">
            <a href="dashboard.php">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="active">
                <i class="fas fa-file-alt"></i>
                <span>SOP Management</span>
            </a>
            <a href="check_sheet.php">
                <i class="fas fa-clipboard-check"></i>
                <span>Check Sheet</span>
            </a>
            <a href="approval.php">
                <i class="fas fa-vote-yea"></i>
                <span>Approval</span>
            </a>
            <a href="qr_generator.php">
                <i class="fas fa-qrcode"></i>
                <span>QR Generator</span>
            </a>
            <a href="report.php">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
            <a href="user_management.php">
                <i class="fas fa-users"></i>
                <span>User Management</span>
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <a href="index.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>

    <div class="main-content">
        <header class="header-bar">
            <div class="header-title">SOP Management</div>
            <div class="user-info">
                <div class="notification-btn" onclick="toggleNotifications()">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>
                <div class="user-details">
                    <strong><?php echo htmlspecialchars($user_email); ?></strong>
                    <small><?php echo htmlspecialchars($user_role); ?></small>
                </div>
            </div>
        </header>

        <main class="page-content">
            <div class="page-header">
                <h1>SOP Management</h1>
                <!-- Tombol ini akan membuka modal -->
                <a href="#" class="btn-primary" id="btnBuatSOPBaru">
                    <i class="fas fa-plus"></i> Buat SOP Baru
                </a>
            </div>

            <div class="filter-controls">
                <div class="search-group">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search SOP...">
                </div>
                
                <select class="select-filter">
                    <option selected>Semua Departemen</option>
                    <option>Production</option>
                    <option>QC</option>
                    <option>HRD</option>
                </select>
            </div>

            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama SOP</th>
                            <th>Departemen</th>
                            <th>Status</th>
                            <th>Versi</th>
                            <th>Last Update</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sop_data as $data): 
                            $status_class = strtolower($data['status']);
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($data['kode']); ?></td>
                                <td><?php echo htmlspecialchars($data['nama']); ?></td>
                                <td><?php echo htmlspecialchars($data['departemen']); ?></td>
                                <td><span class="status-badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($data['status']); ?></span></td>
                                <td><?php echo htmlspecialchars($data['versi']); ?></td>
                                <td><?php echo htmlspecialchars($data['last_update']); ?></td>
                                <td class="action-cell">
                                  <a href="views_sop.php" title="Lihat Prosedur">
                                        <i class="fas fa-eye" title="Lihat"></i>
                                    </a>
                                    <i class="fas fa-pencil-alt" title="Edit"></i>
                                    <i class="fas fa-trash-alt" title="Hapus"></i>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
        
    </div>
    
    <!-- <div class="built-with">
        <span>Built with</span>
        <i class="fas fa-times-circle" style="cursor: pointer; margin-left: 5px;"></i>
    </div> -->
    
    <!-- ================================== -->
    <!-- --- MODAL BUAT SOP BARU --- -->
    <!-- ================================== -->
    <div class="modal-overlay" id="modalBuatSOP">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Buat SOP Baru</h2>
                <button class="modal-close" id="btnCloseModal">&times;</button>
            </div>
            
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="kode_sop">Kode SOP</label>
                        <!-- Nilai default simulasi, nanti digenerate dari backend -->
                        <input type="text" id="kode_sop" value="SOP-2024-002" readonly> 
                    </div>

                    <div class="form-group">
                        <label for="nama_sop">Nama SOP</label>
                        <input type="text" id="nama_sop" placeholder="Nama SOP..." required>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" placeholder="Deskripsi SOP..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Instruksi SOP</label>
                        <div id="instructionContainer">
                            <!-- Instruksi akan ditambahkan di sini secara dinamis -->
                        </div>
                        <div class="btn-add-instruction" id="btnAddInstruction" style="margin-top: 10px;">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Instruksi</span>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col form-group">
                            <label for="departemen">Departemen</label>
                            <select id="departemen" required>
                                <option selected disabled>Pilih Departemen</option>
                                <option>Production</option>
                                <option>QC</option>
                                <option>HRD</option>
                            </select>
                        </div>

                        <div class="form-col form-group">
                            <label for="versi">Versi</label>
                            <input type="text" id="versi" value="1.0" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col form-group">
                            <label for="pin">PIN (Opsional)</label>
                            <input type="number" id="pin" placeholder="000000" maxlength="6">
                            <div class="pin-hint">6 digit PIN untuk akses publik</div>
                        </div>

                        <div class="form-col form-group">
                            <label for="terbuka_publik">Terbuka Publik?</label>
                            <select id="terbuka_publik" required>
                                <option>Tidak</option>
                                <option>Ya</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-secondary" id="btnBatalModal">Batalkan</button>
                <button type="submit" class="btn-primary">Buat SOP</button>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalOverlay = document.getElementById('modalBuatSOP');
            const btnBuatSOPBaru = document.getElementById('btnBuatSOPBaru');
            const btnCloseModal = document.getElementById('btnCloseModal');
            const btnBatalModal = document.getElementById('btnBatalModal');
            const modalContent = document.querySelector('.modal-content');
            const instructionContainer = document.getElementById('instructionContainer');
            const btnAddInstruction = document.getElementById('btnAddInstruction');
            
            let instructionCount = 0;
            let instructions = [];

            // Fungsi untuk menampilkan modal
            function openModal() {
                modalOverlay.classList.add('active');
            }

            // Fungsi untuk menyembunyikan modal
            function closeModal() {
                modalOverlay.classList.remove('active');
            }

            // Fungsi untuk membuat elemen instruksi baru
            function createInstructionElement(index) {
                const instructionDiv = document.createElement('div');
                instructionDiv.className = 'instruction-item';
                instructionDiv.dataset.index = index;
                
                instructionDiv.innerHTML = `
                    <div class="instruction-image-container" id="imageContainer-${index}">
                        <input type="file" id="instructionImage-${index}" accept="image/*">
                        <i class="fas fa-image"></i>
                        <span>Upload Gambar</span>
                        <img id="preview-${index}" alt="Preview">
                    </div>
                    <div class="instruction-content">
                        <div class="instruction-number">Instruksi ${index + 1}</div>
                        <textarea class="instruction-text" id="instructionText-${index}" placeholder="Tulis instruksi di sini..."></textarea>
                    </div>
                    <button type="button" class="instruction-remove" id="remove-${index}">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                
                // Event listener untuk upload gambar
                const fileInput = instructionDiv.querySelector(`#instructionImage-${index}`);
                const imageContainer = instructionDiv.querySelector(`#imageContainer-${index}`);
                const preview = instructionDiv.querySelector(`#preview-${index}`);
                
                fileInput.addEventListener('change', function(e) {
                    handleImageUpload(e, imageContainer, preview);
                });
                
                // Event listener untuk tombol hapus
                const removeBtn = instructionDiv.querySelector(`#remove-${index}`);
                removeBtn.addEventListener('click', function() {
                    removeInstruction(index);
                });
                
                return instructionDiv;
            }

            // Fungsi untuk menangani upload gambar
            function handleImageUpload(event, container, preview) {
                const file = event.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        container.classList.add('has-image');
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Fungsi untuk menambah instruksi baru
            function addInstruction() {
                const instructionElement = createInstructionElement(instructionCount);
                instructionContainer.appendChild(instructionElement);
                instructions.push({
                    index: instructionCount,
                    text: '',
                    image: null
                });
                instructionCount++;
                updateEmptyState();
            }

            // Fungsi untuk menghapus instruksi
            function removeInstruction(index) {
                const element = document.querySelector(`.instruction-item[data-index="${index}"]`);
                if (element) {
                    element.remove();
                    instructions = instructions.filter(inst => inst.index !== index);
                    updateInstructionNumbers();
                    updateEmptyState();
                }
            }

            // Fungsi untuk memperbarui nomor instruksi setelah penghapusan
            function updateInstructionNumbers() {
                const instructionElements = document.querySelectorAll('.instruction-item');
                instructionElements.forEach((element, idx) => {
                    const numberElement = element.querySelector('.instruction-number');
                    if (numberElement) {
                        numberElement.textContent = `Instruksi ${idx + 1}`;
                    }
                });
            }

            // Fungsi untuk memperbarui tampilan kosong
            function updateEmptyState() {
                if (instructions.length === 0) {
                    if (!document.querySelector('.empty-instructions')) {
                        const emptyDiv = document.createElement('div');
                        emptyDiv.className = 'empty-instructions';
                        emptyDiv.textContent = 'Belum ada instruksi. Klik "Tambah Instruksi" untuk memulai.';
                        instructionContainer.appendChild(emptyDiv);
                    }
                } else {
                    const emptyElement = document.querySelector('.empty-instructions');
                    if (emptyElement) {
                        emptyElement.remove();
                    }
                }
            }

            // Event listener untuk tombol tambah instruksi
            btnAddInstruction.addEventListener('click', function() {
                addInstruction();
            });

            // 1. Event listener untuk tombol 'Buat SOP Baru'
            btnBuatSOPBaru.addEventListener('click', function(e) {
                e.preventDefault();
                openModal();
            });

            // 2. Event listener untuk tombol 'x' di header modal
            btnCloseModal.addEventListener('click', closeModal);

            // 3. Event listener untuk tombol 'Batalkan' di footer modal
            btnBatalModal.addEventListener('click', closeModal);

            // 4. Tutup modal ketika mengklik di luar area konten modal
            modalOverlay.addEventListener('click', function(e) {
                // Hanya tutup jika yang diklik adalah overlay-nya sendiri
                if (e.target === modalOverlay) {
                    closeModal();
                }
            });
            
            // Fungsi validasi form
            function validateForm() {
                let isValid = true;
                const namaSOP = document.getElementById('nama_sop').value.trim();
                const departemen = document.getElementById('departemen').value;
                
                // Validasi nama SOP
                if (!namaSOP) {
                    showError('nama_sop', 'Nama SOP harus diisi');
                    isValid = false;
                } else {
                    hideError('nama_sop');
                }
                
                // Validasi departemen
                if (!departemen || departemen === 'Pilih Departemen') {
                    showError('departemen', 'Departemen harus dipilih');
                    isValid = false;
                } else {
                    hideError('departemen');
                }
                
                // Validasi instruksi (minimal satu instruksi dengan teks)
                const instructionItems = document.querySelectorAll('.instruction-item');
                let hasValidInstruction = false;
                
                instructionItems.forEach(item => {
                    const textArea = item.querySelector('.instruction-text');
                    const text = textArea.value.trim();
                    
                    if (text) {
                        hideError(textArea.id);
                        hasValidInstruction = true;
                    } else {
                        showError(textArea.id, 'Instruksi harus diisi');
                        isValid = false;
                    }
                });
                
                if (!hasValidInstruction && instructionItems.length === 0) {
                    alert('Tambahkan minimal satu instruksi');
                    isValid = false;
                }
                
                return isValid;
            }
            
            // Fungsi untuk menampilkan pesan error
            function showError(fieldId, message) {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.classList.add('error');
                    
                    let errorElement = field.parentNode.querySelector('.validation-message');
                    if (!errorElement) {
                        errorElement = document.createElement('div');
                        errorElement.className = 'validation-message';
                        field.parentNode.appendChild(errorElement);
                    }
                    errorElement.textContent = message;
                    errorElement.style.display = 'block';
                }
            }
            
            // Fungsi untuk menyembunyikan pesan error
            function hideError(fieldId) {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.classList.remove('error');
                    const errorElement = field.parentNode.querySelector('.validation-message');
                    if (errorElement) {
                        errorElement.style.display = 'none';
                    }
                }
            }

            // Logika submit form dengan validasi
            const btnSubmit = modalOverlay.querySelector('.modal-footer .btn-primary');
            btnSubmit.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (validateForm()) {
                    // Kumpulkan data instruksi
                    const instructionData = [];
                    document.querySelectorAll('.instruction-item').forEach((item, idx) => {
                        const text = item.querySelector('.instruction-text').value;
                        const hasImage = item.querySelector('.instruction-image-container').classList.contains('has-image');
                        const preview = item.querySelector('.instruction-image-container img');
                        
                        instructionData.push({
                            number: idx + 1,
                            text: text,
                            hasImage: hasImage,
                            imageData: hasImage ? preview.src : null
                        });
                    });
                    
                    // Kumpulkan semua data form
                    const formData = {
                        kode: document.getElementById('kode_sop').value,
                        nama: document.getElementById('nama_sop').value,
                        deskripsi: document.getElementById('deskripsi').value,
                        departemen: document.getElementById('departemen').value,
                        versi: document.getElementById('versi').value,
                        pin: document.getElementById('pin').value,
                        terbuka_publik: document.getElementById('terbuka_publik').value,
                        instruksi: instructionData
                    };
                    
                    console.log('Data form lengkap:', formData);
                    alert('SOP Baru siap dibuat! (Simulasi)\n\nJumlah instruksi: ' + instructionData.length + '\nData lengkap telah dicetak di console');
                    closeModal();
                    // Di sini Anda akan menambahkan logika AJAX/Fetch untuk mengirim data ke server
                }
            });
            
            // Event listeners untuk real-time validation
            document.getElementById('nama_sop').addEventListener('blur', function() {
                if (!this.value.trim()) {
                    showError('nama_sop', 'Nama SOP harus diisi');
                } else {
                    hideError('nama_sop');
                }
            });
            
            document.getElementById('departemen').addEventListener('change', function() {
                if (!this.value || this.value === 'Pilih Departemen') {
                    showError('departemen', 'Departemen harus dipilih');
                } else {
                    hideError('departemen');
                }
            });

            // Inisialisasi tampilan kosong
            updateEmptyState();
        });

        // Toggle sidebar untuk mobile
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            sidebar.classList.toggle('collapsed');
            
            if (window.innerWidth <= 768) {
                sidebar.style.transform = sidebar.style.transform === 'translateX(-100%)' ? 'translateX(0)' : 'translateX(-100%)';
            }
        }

        // Toggle notifications
        function toggleNotifications() {
            // Placeholder untuk notification dropdown
            alert('Notifications panel would open here');
        }

        // Mobile responsiveness
        function handleResize() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            if (window.innerWidth <= 768) {
                sidebar.style.transform = 'translateX(-100%)';
                mainContent.style.marginLeft = '0';
            } else {
                sidebar.style.transform = 'translateX(0)';
                mainContent.style.marginLeft = 'var(--sidebar-width)';
            }
        }

        // Event listeners
        window.addEventListener('resize', handleResize);
        document.addEventListener('DOMContentLoaded', handleResize);

        // Smooth scroll untuk navigation
        document.querySelectorAll('.sidebar-nav a').forEach(link => {
            link.addEventListener('click', function(e) {
                // Hapus class active dari semua link
                document.querySelectorAll('.sidebar-nav a').forEach(a => a.classList.remove('active'));
                // Tambahkan class active ke link yang diklik
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>