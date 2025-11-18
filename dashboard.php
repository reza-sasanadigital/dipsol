<?php
// Bagian PHP - Simulasi Sesi Login
// Dalam aplikasi nyata, Anda harus menggunakan session_start() dan memeriksa variabel sesi.
// Untuk keperluan demo ini, kita hanya memastikan file ini bisa diakses.
// Jika Anda ingin mengintegrasikannya dengan index.php, Anda bisa menambahkan:
/*
session_start();
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}
*/

$user_email = "user@dipsol.com";
$user_role = "Admin";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PT Dipsol Indonesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght=400;500;700&display=swap" rel="stylesheet">
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
            --blue-card: #007bff;
            --orange-card: #ffc107;
            --red-card: #dc3545;
            --green-card: #28a745;
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

        /* Dashboard Grid */
        .dashboard-grid {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        
        .section-grid {
            padding: 20px;
            display: grid;
            grid-template-columns: 2fr 1fr; /* Untuk Aktivitas Dokumen (lebar) dan Status Distribusi (sempit) */
            gap: 20px;
        }
        
        .card-full {
            grid-column: span 2; /* Agar chart Aktivitas Dokumen lebih lebar */
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }
        
        .card-half {
            grid-column: span 1;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        /* Info Cards (Kotak Angka) */
        .info-card {
            background-color: var(--card-bg);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-content h3 {
            font-size: 1.5em;
            margin: 0;
            font-weight: 500;
        }

        .card-content p {
            margin: 5px 0 0;
            color: var(--secondary-text);
            font-size: 0.9em;
        }

        .card-icon {
            font-size: 2.5em;
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        /* Warna Cards */
        .card-total-sop .card-icon { background-color: var(--blue-card); }
        .card-check-sheet .card-icon { background-color: var(--orange-card); }
        .card-pending-approval .card-icon { background-color: var(--red-card); }
        .card-completion-rate .card-icon { background-color: var(--green-card); }
        
        /* Bar chart dan Donut chart */
        .chart-header {
            font-size: 1.2em;
            font-weight: 500;
            margin-bottom: 20px;
            color: var(--text-color);
        }
        
        /* Placeholder Chart Styles (Simulasi) */
        .bar-chart-placeholder {
            height: 250px;
            border-left: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            display: flex;
            align-items: flex-end;
            justify-content: space-around;
            padding-bottom: 10px;
        }
        
        .bar-chart-placeholder .bar {
            width: 30px;
            background-color: var(--primary-color);
            margin: 0 5px;
            border-radius: 4px 4px 0 0;
            position: relative;
        }
        
        .bar-chart-placeholder .bar::after {
            content: attr(data-label);
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.8em;
            color: var(--secondary-text);
        }
        
        /* Tinggi bar disimulasikan */
        .bar[data-height="40"] { height: 40%; }
        .bar[data-height="70"] { height: 70%; }
        .bar[data-height="50"] { height: 50%; }
        .bar[data-height="95"] { height: 95%; }
        .bar[data-height="85"] { height: 85%; }
        .bar[data-height="75"] { height: 75%; }
        .bar[data-height="30"] { height: 30%; }
        
        .y-axis-label {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) rotate(-90deg);
            font-size: 0.8em;
            color: var(--secondary-text);
        }
        
        .y-axis-tick {
            position: absolute;
            width: 100%;
            border-top: 1px dashed #eee;
            color: var(--secondary-text);
            font-size: 0.8em;
            padding-right: 5px;
            text-align: right;
            box-sizing: border-box;
        }
        
        .y-28 { top: 0; }
        .y-21 { top: 25%; }
        .y-14 { top: 50%; }
        .y-7 { top: 75%; }
        
        .chart-wrapper {
            position: relative;
        }

        /* Donut Chart Placeholder (Simulasi) */
        .donut-chart-placeholder {
            width: 100%;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }
        
        /* Simulasi Donut menggunakan SVG atau CSS conic-gradient (digunakan CSS di sini) */
        .donut-container {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: conic-gradient(
                #28a745 0% 55%, /* Hijau 55% */
                #ffc107 55% 85%, /* Oranye 30% (55 ke 85) */
                #dc3545 85% 100% /* Merah 15% (85 ke 100) */
            );
            position: relative;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        
        .donut-hole {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
        }
        
        /* Info Legend */
        .legend-list {
            list-style: none;
            padding: 0;
            margin-top: 20px;
            font-size: 0.9em;
        }
        
        .legend-list li {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }
        
        .legend-list li .color-box {
            width: 12px;
            height: 12px;
            border-radius: 3px;
            margin-right: 10px;
        }
        
        .legend-approved { background-color: #28a745; }
        .legend-review { background-color: #ffc107; }
        .legend-rejected { background-color: #dc3545; }
        
        /* Built With (Simulasi di pojok kanan bawah) */
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
        }
        
        .built-with span {
            margin-right: 5px;
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

            .dashboard-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
                padding: 15px;
            }

            .section-grid {
                grid-template-columns: 1fr;
                padding: 15px;
            }

            .card-full, .card-half {
                grid-column: span 1;
            }

            .info-card {
                padding: 15px;
            }

            .card-icon {
                font-size: 2em;
                width: 40px;
                height: 40px;
            }

            .card-content h3 {
                font-size: 1.2em;
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
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .header-title {
                font-size: 1.1em;
            }

            .sidebar {
                width: 100%;
            }
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

    </style>
</head>
<body>
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
            <a href="dashboard.php" class="active">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>
            <a href="sop_management.php">
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

    <button class="mobile-menu-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="main-content">
        <header class="header-bar">
            <div class="header-title">Dashboard</div>
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

        <main>
            <div class="dashboard-grid">
                
                <div class="info-card card-total-sop">
                    <div class="card-content">
                        <h3>Total SOP</h3>
                        <p>324</p>
                        <small>12 Active, 8 Revisit</small>
                    </div>
                    <div class="card-icon"><i class="fas fa-file-invoice"></i></div>
                </div>

                <div class="info-card card-check-sheet">
                    <div class="card-content">
                        <h3>Check Sheet</h3>
                        <p>156</p>
                        <small>Submitted this month</small>
                    </div>
                    <div class="card-icon"><i class="fas fa-tasks"></i></div>
                </div>
                
                <div class="info-card card-pending-approval">
                    <div class="card-content">
                        <h3>Pending Approval</h3>
                        <p>24</p>
                        <small>Requires action</small>
                    </div>
                    <div class="card-icon"><i class="fas fa-exclamation-circle"></i></div>
                </div>

                <div class="info-card card-completion-rate">
                    <div class="card-content">
                        <h3>Completion Rate</h3>
                        <p>89%</p>
                        <small>Last 30 days</small>
                    </div>
                    <div class="card-icon"><i class="fas fa-chart-line"></i></div>
                </div>
            </div>
            
            <div class="section-grid">
                
                <div class="card-full">
                    <h3 class="chart-header">Document Activity</h3>
                    <div class="chart-wrapper">
                        <div class="y-axis-tick y-28">28</div>
                        <div class="y-axis-tick y-21">21</div>
                        <div class="y-axis-tick y-14">14</div>
                        <div class="y-axis-tick y-7">7</div>

                        <div class="bar-chart-placeholder">
                            <div class="bar" data-height="40" data-label="Mon"></div>
                            <div class="bar" data-height="70" data-label="Tue"></div>
                            <div class="bar" data-height="50" data-label="Wed"></div>
                            <div class="bar" data-height="95" data-label="Thu"></div>
                            <div class="bar" data-height="85" data-label="Fri"></div>
                            <div class="bar" data-height="75" data-label="Sat"></div>
                            <div class="bar" data-height="30" data-label="Sun"></div>
                        </div>
                    </div>
                </div>

                <div class="card-half">
                    <h3 class="chart-header">Status Distribution</h3>
                    
                    <div class="donut-chart-placeholder">
                        <div class="donut-container">
                            <div class="donut-hole"></div>
                        </div>
                    </div>
                    
                    <ul class="legend-list">
                        <li><span class="color-box legend-approved"></span> Approved</li>
                        <li><span class="color-box legend-review"></span> In Review</li>
                        <li><span class="color-box legend-rejected"></span> Rejected</li>
                    </ul>
                </div>
                
            </div>
        </main>
        
    </div>
    
    <!-- <div class="built-with">
        <span>Built with</span>
        <i class="fas fa-times-circle" style="cursor: pointer; margin-left: 5px;"></i>
    </div> -->

    <script>
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

        // Interactive hover effect untuk cards
        document.querySelectorAll('.info-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
                this.style.boxShadow = 'var(--shadow-md)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.08)';
            });
        });
    </script>
</body>
</html>