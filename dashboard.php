<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Data produk Polgan Mart (hanya kode dan nama)
$daftar_produk = [
    [
        'kode_barang' => 'K001',
        'nama_barang' => 'Beras Premium 5kg'
    ],
    [
        'kode_barang' => 'K002',
        'nama_barang' => 'Minyak Goreng 2L'
    ],
    [
        'kode_barang' => 'K003',
        'nama_barang' => 'Gula Pasir 1kg'
    ],
    [
        'kode_barang' => 'K004',
        'nama_barang' => 'Telur Ayam (Tray)'
    ],
    [
        'kode_barang' => 'K005',
        'nama_barang' => 'Sabun Mandi Cair'
    ],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polgan Mart - Daftar Produk (Kode & Nama)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        /* Header Polgan Mart */
        .header {
            background-color: #004d40; /* Hijau Tua */
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 5px solid #ffab00; /* Kuning Mart */
        }
        .header h1 {
            margin: 0;
            font-size: 2.5em;
        }
        .container {
            width: 70%; /* Dibuat lebih ramping karena kolom lebih sedikit */
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        
        /* Gaya untuk Tabel Produk */
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .product-table th, .product-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .product-table th {
            background-color: #00796b;
            color: white;
            text-align: center;
        }
        .product-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🛒 Polgan Mart - Daftar Nama Produk</h1>
    </div>

    <div class="container">
        <h2>Data 5 Produk Inventaris</h2>
        
        <table class="product-table">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Loop melalui array $daftar_produk
                foreach ($daftar_produk as $produk): 
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($produk['kode_barang']); ?></td>
                    <td><?php echo htmlspecialchars($produk['nama_barang']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>