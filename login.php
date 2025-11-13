<?php
session_start();

// Cek apakah user sudah login
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

// Proses login saat form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Login sederhana (username: ridho, password: 12345)
    if ($username === 'ridho' && $password === '12345') {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'Mahasiswa'; // Contoh role
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POLGAN MART</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #4c8cf5, #1a57e2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: #fff;
            padding: 2.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 1rem;
            color: #1a57e2;
        }

        .login-container p {
            margin-bottom: 1.5rem;
            color: #666;
        }

        .input-group {
            text-align: left;
            margin-bottom: 1.2rem;
        }

        .input-group label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 500;
            color: #333;
        }

        .input-group input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: #1a57e2;
            outline: none;
            box-shadow: 0 0 5px rgba(26, 87, 226, 0.3);
        }

        .btn {
            background: #1a57e2;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            font-size: 1rem;
            width: 100%;
        }

        .btn:hover {
            background: #0f3fb0;
        }

        .error-message {
            background: #ffe6e6;
            color: #b30000;
            border: 1px solid #ff9999;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .footer-text {
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>POLGAN MART</h2>
        <p>Silakan login untuk melanjutkan</p>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?= $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Masukkan username" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <div class="footer-text">
            &copy; <?= date('Y'); ?> POLGAN MART — Sistem Penjualan Sederhana
        </div>
    </div>

</body>
</html>
