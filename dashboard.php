<?php
// Pastikan session dimulai di awal skrip
session_start();

// Inisialisasi atau Reset Daftar Belanja di Session
if (!isset($_SESSION['belanja'])) {
    $_SESSION['belanja'] = [];
}

// 1. Logika Hapus Keranjang
if (isset($_POST['action']) && $_POST['action'] == 'clear') {
    $_SESSION['belanja'] = [];
    // Redirect untuk menghindari pengiriman ulang form saat refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// 2. Logika Tambah Barang (Diproses saat formulir dikirim)
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $kode = filter_input(INPUT_POST, 'kode_barang', FILTER_SANITIZE_STRING);
    $nama = filter_input(INPUT_POST, 'nama_barang', FILTER_SANITIZE_STRING);
    $harga = filter_input(INPUT_POST, 'harga', FILTER_VALIDATE_INT);
    $jumlah = filter_input(INPUT_POST, 'jumlah', FILTER_VALIDATE_INT);

    // Validasi dasar
    if ($kode && $nama && $harga > 0 && $jumlah > 0) {
        $subtotal = $harga * $jumlah;
        // Tambahkan item ke session belanja
        $_SESSION['belanja'][] = [
            $kode,      // 0: Kode
            $nama,      // 1: Nama
            $harga,     // 2: Harga Satuan
            $jumlah,    // 3: Jumlah
            $subtotal   // 4: Subtotal
        ];
    }
    // Redirect untuk menghindari pengiriman ulang form saat refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// --- Logika Perhitungan Total (Dijalankan setiap load) ---
$grandtotal = 0;
foreach ($_SESSION['belanja'] as $item) {
    $grandtotal += $item[4];
}

$diskon = 0;
if ($grandtotal > 100000) {
    $diskon = $grandtotal * 0.10;
}
$total_akhir = $grandtotal - $diskon;


// Format angka ke Rupiah
function format_rupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// Fungsi untuk mendapatkan teks Diskon
function get_diskon_text($diskon_amount, $grandtotal) {
    if ($grandtotal == 0 || $diskon_amount == 0) return format_rupiah(0);
    $persen = round(($diskon_amount / $grandtotal) * 100);
    return format_rupiah($diskon_amount) . ($persen > 0 ? " (" . $persen . "%)" : "");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>POLGAN MART - Sistem Penjualan Sederhana</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <style>
        /* CSS Dibiarkan sama */
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }
        body {
            background: #f5f8ff;
            color: #333;
            padding: 0;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            background: #fff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        .left-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .logo {
            background: #1a57e2;
            color: white;
            font-weight: 600;
            border-radius: 5px;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.1rem;
        }
        .title h2 {
            font-size: 1.2rem;
            color: #1a57e2;
            margin-bottom: 3px;
        }
        .title p {
            font-size: 0.8rem;
            color: #777;
        }
        .right-section {
            text-align: right;
            line-height: 1.4;
        }
        .right-section p {
            font-size: 0.9rem;
            color: #333;
        }
        .right-section .role {
            font-size: 0.8rem;
            color: #777;
        }
        .right-section a {
            display: block;
            margin-top: 5px;
            font-size: 0.9rem;
            color: #1a57e2;
            text-decoration: none;
        }
        .content {
            background: #fff;
            margin: 0 auto;
            padding: 2rem;
            width: 90%;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
        }
        /* Menggunakan name attribute untuk form submission */
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        .form-group input[type="number"] {
            -moz-appearance: textfield;
            appearance: textfield;
        }
        .actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            margin-bottom: 3rem;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #1a57e2;
            color: white;
        }
        .btn-secondary {
            background-color: #f0f0f0;
            color: #333;
        }
        h3.list-title {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
            font-weight: 600;
            padding-top: 1.5rem;
            border-top: 1px solid #e6e6e6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            padding: 10px 15px;
            text-align: left;
            font-size: 0.95rem;
        }
        thead tr {
            border-bottom: 1px solid #e6e6e6;
        }
        th {
            font-weight: 600;
            color: #777;
        }
        tbody tr:last-child td {
            border-bottom: none;
        }
        .table-summary td {
            border-top: none !important;
            border-bottom: none !important;
            font-weight: 400;
        }
        .table-summary tr:nth-child(2) td,
        .table-summary tr:nth-child(3) td {
            padding-top: 5px;
        }
        .table-summary tr:last-child td {
            font-weight: 600;
            font-size: 1.05rem;
            border-top: 1px solid #e6e6e6 !important;
            padding-top: 10px;
        }
        .summary-label {
            text-align: right;
            font-weight: 600;
            width: 60%;
        }
        .summary-value {
            text-align: right;
            font-weight: 500;
            width: 40%;
        }
        .total-pay-value {
            color: #1a57e2;
        }
        .empty-cart-btn {
            background-color: transparent;
            color: #777;
            font-size: 0.9rem;
            text-align: left;
            margin-top: 15px;
            padding-left: 0;
            text-decoration: none;
            /* Diubah menjadi tombol submit untuk form */
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="left-section">
            <div class="logo">PM</div>
            <div class="title">
                <h2>--POLGAN MART--</h2>
                <p>Sistem Penjualan Sederhana</p>
            </div>
        </div>
        <div class="right-section">
            <p>Selamat datang, **Ridho**<br>
            <span class="role">Role: Mahasiswa</span></p>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <main class="content">
        <form method="POST" action="">
            <div class="input-form">
                <input type="hidden" name="action" value="add">
                <div class="form-group">
                    <label for="kode_barang">Kode Barang</label>
                    <input type="text" id="kode_barang" name="kode_barang" placeholder="Masukkan Kode Barang" required>
                </div>
                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" placeholder="Masukkan Nama Barang" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" id="harga" name="harga" placeholder="Masukkan Harga" step="1000" min="0" required>
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah" min="1" required>
                </div>
                <div class="actions">
                    <button class="btn btn-primary" type="submit">Tambahkan</button>
                    <button class="btn btn-secondary" type="reset">Batal</button>
                </div>
            </div>
        </form>

        <h3 class="list-title">Daftar Pembelian</h3>

        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody id="daftar-pembelian-body">
                <?php foreach ($_SESSION['belanja'] as $item): ?>
                <tr data-subtotal="<?= $item[4]; ?>">
                    <td><?= $item[0]; ?></td>
                    <td><?= $item[1]; ?></td>
                    <td class="harga-satuan" data-harga="<?= $item[2]; ?>"><?= format_rupiah($item[2]); ?></td>
                    <td><?= $item[3]; ?></td>
                    <td class="subtotal-item" style="text-align: right;"><?= format_rupiah($item[4]); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <table class="table-summary">
            <tr>
                <td class="summary-label">Total Belanja</td>
                <td class="summary-value" id="total-belanja-value"><?= format_rupiah($grandtotal); ?></td>
            </tr>

            <tr>
                <td class="summary-label">Diskon</td>
                <td class="summary-value" id="diskon-value"><?= get_diskon_text($diskon, $grandtotal); ?></td>
            </tr>

            <tr>
                <td class="summary-label">Total Bayar</td>
                <td class="summary-value total-pay-value" id="total-bayar-value">**<?= format_rupiah($total_akhir); ?>**</td>
            </tr>
        </table>

        <div style="margin-top: 15px;">
            <form method="POST" action="">
                <input type="hidden" name="action" value="clear">
                <button class="btn empty-cart-btn" type="submit">Kosongkan Keranjang</button>
            </form>
        </div>
    </main>

    </body>
</html>