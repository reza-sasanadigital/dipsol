<?php
// 1. MEMULAI SESSION
session_start();

// Bagian PHP
$error_message = '';
$demo_email = 'user@dipsol.com';
$demo_password = 'password123';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($email === $demo_email && $password === $demo_password) {
        // Logika sukses login
        
        // Simpan data login di session
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_email'] = $demo_email;
        $_SESSION['user_role'] = 'Admin'; 

        // 2. REDIRECT ke dashboard.php
        header('Location: dashboard.php');
        exit(); // Penting untuk menghentikan eksekusi script setelah redirect
    } else {
        $error_message = 'Email atau Password salah.';
        // Hapus data session jika ada, memastikan sesi bersih
        session_unset();
        session_destroy();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - PT Dipsol Indonesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* CSS */
        :root {
            --primary-color: #004d99; /* Biru gelap */
            --secondary-color: #f7f7f7; /* Abu-abu terang untuk latar belakang input */
            --text-color: #333;
            --border-color: #ccc;
            --error-bg: #f8d7da;
            --error-text: #721c24;
            --success-bg: #d4edda;
            --success-text: #155724;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5; /* Latar belakang abu-abu sangat terang */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: var(--text-color);
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 1.8em;
            color: var(--text-color);
            margin-bottom: 5px;
        }

        .header p {
            font-size: 1em;
            color: #666;
            margin-top: 0;
        }
        
        /* Mengganti logo dengan ikon kustom seperti di gambar */
        .logo-icon {
            background-color: var(--primary-color);
            width: 48px;
            height: 48px;
            margin: 0 auto 10px;
            border-radius: 6px;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Menggunakan unicode 'M' sederhana untuk simulasi ikon */
            color: white;
            font-size: 30px;
            font-weight: bold;
            line-height: 1;
        }

        .login-card {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .login-card h2 {
            text-align: center;
            font-size: 1.5em;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .input-group {
            display: flex;
            align-items: center;
            background-color: var(--secondary-color);
            border-radius: 6px;
            padding: 10px;
        }

        .input-group input {
            flex-grow: 1;
            border: none;
            outline: none;
            background: transparent;
            font-size: 1em;
            padding: 0 10px;
        }

        .input-group .icon {
            color: #999;
            font-size: 1.2em;
        }

        .btn-masuk {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .btn-masuk:hover {
            background-color: #003366;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8em;
            color: #999;
        }

        .alert {
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 0.9em;
            text-align: center;
        }

        .alert-error {
            background-color: var(--error-bg);
            color: var(--error-text);
            border: 1px solid #f5c6cb;
        }
        
        .demo-info {
            background-color: #fdeded;
            color: #d83d47;
            padding: 12px;
            border-radius: 6px;
            font-size: 0.9em;
            text-align: center;
            margin-top: 50px;
            border: 1px solid #f1adad;
        }
        
        .built-with {
            position: fixed;
            bottom: 10px;
            right: 10px;
            background-color: #333;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.8em;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        
        .built-with span {
            margin-right: 5px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-icon">M</div> <h1>PT Dipsol Indonesia</h1>
            <p>SOP & Check Sheet Management System</p>
        </div>

        <div class="login-card">
            <h2>Masuk</h2>

            <?php if ($error_message): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php">
                <div class="form-group">
                    <div class="input-group">
                        <span class="icon"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="email" name="email" placeholder="user@example.com" required
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" placeholder="********" required>
                    </div>
                </div>

                <button type="submit" class="btn-masuk">Masuk</button>
            </form>

            <div class="footer-text">
                Sistem SOP & Check Sheet PT Dipsol Indonesia
            </div>
        </div>
        
        <div class="demo-info">
            Demo: user@dipsol.com / password123
        </div>

    </div>
    
    <div class="built-with">
        <span>Built with</span>
        <i class="fas fa-times-circle" style="cursor: pointer; margin-left: 5px;"></i> </div>
</body>
</html>