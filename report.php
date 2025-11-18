<?php
// Di sini Anda bisa menambahkan logika PHP untuk mengambil data laporan dari database.

// Contoh data statis untuk grafik (simulasi data Chart.js)
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
$data_sop = [45, 52, 48, 61, 55]; // Contoh jumlah SOP yang disubmit
$data_checksheet = [32, 38, 35, 41, 39]; // Contoh jumlah Check Sheet yang disubmit

$reportTitle = "Monthly Document Submissions";

// Data akan di-encode ke JSON untuk digunakan oleh Chart.js
$chartDataJson = json_encode([
    'labels' => $months,
    'datasets' => [
        [
            'label' => 'SOP Submissions',
            'data' => $data_sop,
            'backgroundColor' => '#0d6efd', // Biru (Warna Primary Bootstrap)
        ],
        [
            'label' => 'Check Sheet Submissions',
            'data' => $data_checksheet,
            'backgroundColor' => '#fd7e14', // Oranye (Warna Warning/Accent)
        ]
    ]
]);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    
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

            .content {
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

        /* Style untuk container chart */
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>

<button class="mobile-menu-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<nav class="sidebar" id="sidebar">
     <div class="sidebar">
       <div class="sidebar-header">
            <a href="dashboard.php" class="sidebar-logo">
                <span>PT. DIPSOL INDONESIA</span>
            </a>
            <!-- <button class="sidebar-close" onclick="toggleSidebar()">
                <i class="fas fa-times"></i>
            </button> -->
        </div>
    
    <div class="sidebar-nav">
        <a href="dashboard.php">
           <i class="fas fa-th-large"></i>
            Dashboard
        </a>
        <a href="sop_management.php">
              <i class="fas fa-file-alt"></i>
            SOP Management
        </a>
        <a href="check_sheet.php">
            <i class="fas fa-clipboard-check"></i>
            Check Sheet
        </a>
        <a href="approval.php">
           <i class="fas fa-vote-yea"></i>
            Approval
        </a>
        <a href="qr_generator.php">
             <i class="fas fa-qrcode"></i>
            QR Generator
        </a>
        <a href="report.php"  class="active">
            <i class="fas fa-chart-bar"></i>
            Reports
        </a>
        <a href="user_management.php">
            <i class="fas fa-users"></i>
            User Management
        </a>
    </div>
    
    <div class="sidebar-footer">
        <a href="logout.php">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
    </div>
</nav>

<div class="main-content">
    <header class="header-bar">
        <div class="header-title">Reports</div>
        <div class="user-info">
            <div class="notification-btn" onclick="toggleNotifications()">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </div>
            <div class="user-details">
                <strong>user@dipsol.com</strong>
                <small>Admin</small>
            </div>
        </div>
    </header>

    <main class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Reports</h1>
            <button class="btn btn-warning text-white">
                <i class="fas fa-file-export me-1"></i> Export Report
            </button>
        </div>

        <div class="card p-4 shadow-sm">
            <h4 class="fw-bold mb-4"><?= htmlspecialchars($reportTitle) ?></h4>
            
            <div class="chart-container">
                <canvas id="monthlySubmissionsChart"></canvas>
            </div>

            </div>

        <div class="position-fixed bottom-0 end-0 p-3">
            <div class="bg-dark text-white p-2 rounded d-flex align-items-center" style="font-size: 0.85em;">
                Built with 
                <img src="path/to/logo-x.png" alt="X Logo" style="height: 15px; margin-left: 5px;">
                <button class="btn-close btn-close-white ms-2" aria-label="Close"></button>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Mobile menu toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarClose = document.getElementById('sidebarClose');
    
    // Open sidebar when mobile menu toggle is clicked
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            sidebar.classList.add('active');
        });
    }
    
    // Close sidebar when close button is clicked
    if (sidebarClose) {
        sidebarClose.addEventListener('click', function() {
            sidebar.classList.remove('active');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !mobileMenuToggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });
    
    // Toggle notifications
    function toggleNotifications() {
        // Placeholder untuk notification dropdown
        alert('Notifications panel would open here');
    }
    
    // Smooth scroll untuk navigation
    document.querySelectorAll('.sidebar-nav a').forEach(link => {
        link.addEventListener('click', function(e) {
            // Hapus class active dari semua link
            document.querySelectorAll('.sidebar-nav a').forEach(a => a.classList.remove('active'));
            // Tambahkan class active ke link yang diklik
            this.classList.add('active');
        });
    });
    
    // Ambil data JSON dari PHP
    const chartData = <?= $chartDataJson ?>;
    
    const ctx = document.getElementById('monthlySubmissionsChart').getContext('2d');
    
    // Buat objek Chart
    new Chart(ctx, {
        type: 'bar', // Tipe grafik batang (bar chart)
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false, // Penting agar responsive di dalam chart-container
            scales: {
                y: {
                    beginAtZero: true,
                    // Batas maksimal Y Axis disesuaikan agar cocok dengan desain (max sekitar 80)
                    max: 80,
                    ticks: {
                        stepSize: 20 // Langkah sumbu Y
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)', // Garis grid tipis
                    }
                },
                x: {
                    grid: {
                        display: false // Hilangkan garis grid vertikal
                    }
                }
            },
            plugins: {
                legend: {
                    display: false // Sembunyikan legenda jika hanya dua set data
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            }
        }
    });
});
</script>
</body>
</html>