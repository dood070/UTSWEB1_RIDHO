<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// summit 5
// Data produk Polgan Mart (sekarang ditambahkan harga untuk perhitungan transaksi)
$daftar_produk = [
    [
        'kode_barang' => 'K001',
        'nama_barang' => 'Beras Premium 5kg',
        'harga_barang' => 65000 // TAMBAHAN: Harga untuk perhitungan
    ],
    [
        'kode_barang' => 'K002',
        'nama_barang' => 'Minyak Goreng 2L',
        'harga_barang' => 32000 // TAMBAHAN: Harga untuk perhitungan
    ],
    [
        'kode_barang' => 'K003',
        'nama_barang' => 'Gula Pasir 1kg',
        'harga_barang' => 17500 // TAMBAHAN: Harga untuk perhitungan
    ],
    [
        'kode_barang' => 'K004',
        'nama_barang' => 'Telur Ayam (Tray)',
        'harga_barang' => 50000 // TAMBAHAN: Harga untuk perhitungan
    ],
    [
        'kode_barang' => 'K005',
        'nama_barang' => 'Sabun Mandi Cair',
        'harga_barang' => 24000 // TAMBAHAN: Harga untuk perhitungan
    ],
];

// commit 6

$transaksi_penjualan = [];
$grandtotal = 0; // Inisialisasi $grandtotal

// Jumlah item transaksi yang diacak (Misal: 3 sampai 6 item)
$jumlah_item_transaksi = rand(3, 6); 
$jumlah_produk_tersedia = count($daftar_produk);

// Perulangan FOR untuk membuat item transaksi acak
for ($i = 0; $i < $jumlah_item_transaksi; $i++) {
    // a. Pilih produk secara acak
    $index_produk_acak = rand(0, $jumlah_produk_tersedia - 1);
    $produk = $daftar_produk[$index_produk_acak];

    // b. Tentukan jumlah pembelian acak ($jumlah)
    $jumlah = rand(1, 5);
    
    // c. Hitung total ($total)
    $total = $produk['harga_barang'] * $jumlah;
    
    // d. Masukkan data ke dalam array transaksi
    $transaksi_penjualan[] = [
        'beli' => $produk['kode_barang'] . ' - ' . $produk['nama_barang'], // Representasi $beli
        'jumlah' => $jumlah, // Representasi $jumlah
        'harga_satuan' => $produk['harga_barang'],
        'total' => $total // Representasi $total
    ];
    
    // e. Akumulasikan Grand Total ($grandtotal)
    $grandtotal += $total;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polgan Mart - Dashboard Penjualan</title> <style>
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
            width: 90%; /* Disesuaikan agar tabel transaksi terlihat baik */
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-bottom: 40px; 
        }
        
        /* Gaya untuk Tabel Produk dan Transaksi */
        .product-table, .sales-table { 
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .product-table th, .product-table td, .sales-table th, .sales-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .product-table th, .sales-table th {
            background-color: #00796b;
            color: white;
            text-align: center;
        }
        .product-table tbody tr:nth-child(even), .sales-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        /* --- START KODE TAMBAHAN BARU: Style untuk Grand Total --- */
        .text-right {
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
            background-color: #e0f2f1;
            font-size: 1.2em;
        }
        .logout-link {
            display: block;
            margin-top: 30px;
            text-align: right;
        }
        .logout-link a {
            color: #d32f2f;
            text-decoration: none;
            padding: 8px 15px;
            border: 1px solid #d32f2f;
            border-radius: 4px;
        }
        /* --- END KODE TAMBAHAN BARU: Style untuk Grand Total --- */
    </style>
</head>
<body>
    <div class="header">
        <h1>🛒 Polgan Mart - Dashboard Penjualan</h1>
    </div>

    <div class="container">
        <div style="text-align: center; margin-bottom: 30px; padding: 10px; border: 1px dashed #ccc;">
            <h2>Selamat datang, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>!</h2>
            <p>Role: <?php echo htmlspecialchars($_SESSION['role'] ?? 'Kasir'); ?></p>
        </div>
        <h2>Data 5 Produk Inventaris (Master Data)</h2>
        
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

        <h2 style="margin-top: 40px;">Simulasi Transaksi Penjualan Acak</h2>
        <p>Total Item yang Dibeli: **<?php echo $jumlah_item_transaksi; ?>**</p>
        
        <table class="sales-table">
            <thead>
                <tr>
                    <th>Barang Dibeli (`$beli`)</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Jumlah (`$jumlah`)</th>
                    <th class="text-right">Total (`$total`)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Loop melalui array transaksi yang dihasilkan perulangan for
                foreach ($transaksi_penjualan as $item): 
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['beli']); ?></td>
                    <td class="text-right">Rp <?php echo number_format($item['harga_satuan'], 0, ',', '.'); ?></td>
                    <td class="text-right"><?php echo htmlspecialchars($item['jumlah']); ?></td>
                    <td class="text-right">Rp <?php echo number_format($item['total'], 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3">**GRAND TOTAL BELANJA (`$grandtotal`)**</td>
                    <td class="text-right">**Rp <?php echo number_format($grandtotal, 0, ',', '.'); ?>**</td>
                </tr>
            </tfoot>
        </table>
        
        <div class="logout-link">
            <a href="logout.php">Keluar (Logout)</a>
        </div>
        </div>
</body>
</html>

<!-- summit 7 -->
?>

        
        /* Gaya untuk Tabel Produk dan Transaksi */
        .product-table, .sales-table { 
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .product-table th, .product-table td, .sales-table th, .sales-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .product-table th, .sales-table th {
            background-color: #00796b;
            color: white;
            text-align: center;
        }
        .product-table tbody tr:nth-child(even), .sales-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        /* Style untuk Grand Total */
        .text-right {
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
            background-color: #e0f2f1;
            font-size: 1.2em;
        }
        .logout-link {
            display: block;
            margin-top: 30px;
            text-align: right;
        }
        .logout-link a {
            color: #d32f2f;
            text-decoration: none;
            padding: 8px 15px;
            border: 1px solid #d32f2f;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🛒 Polgan Mart - Dashboard Penjualan</h1>
    </div>

    <div class="container">
        <div style="text-align: center; margin-bottom: 30px; padding: 10px; border: 1px dashed #ccc;">
            <h2>Selamat datang, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>!</h2>
            <p>Role: <?php echo htmlspecialchars($_SESSION['role'] ?? 'Kasir'); ?></p>
        </div>

        <h2>Data 5 Produk Inventaris (Master Data)</h2>
        
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

        <h2 style="margin-top: 40px;">Simulasi Transaksi Penjualan Acak (Commit 6)</h2>
        <p>Total Item yang Dibeli: **<?php echo $jumlah_item_transaksi; ?>**</p>
        
        <table class="sales-table">
            <thead>
                <tr>
                    <th>Barang Dibeli (`$beli`)</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Jumlah (`$jumlah`)</th>
                    <th class="text-right">Total (`$total`)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Loop melalui array transaksi yang dihasilkan perulangan for
                foreach ($transaksi_penjualan as $item): 
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['beli']); ?></td>
                    <td class="text-right">Rp <?php echo number_format($item['harga_satuan'], 0, ',', '.'); ?></td>
                    <td class="text-right"><?php echo htmlspecialchars($item['jumlah']); ?></td>
                    <td class="text-right">Rp <?php echo number_format($item['total'], 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3">**GRAND TOTAL BELANJA (`$grandtotal`)**</td>
                    <td class="text-right">**Rp <?php echo number_format($grandtotal, 0, ',', '.'); ?>**</td>
                </tr>
            </tfoot>
        </table>

        <h2 style="margin-top: 40px;">Detail Pembelian Menggunakan Perulangan FOREACH (Commit 7)</h2>
        <p>Total Item yang Dibeli: **<?php echo count($transaksi_detail_foreach); ?>**</p>
        
        <table class="sales-table">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-right">Total Harga Per Item</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Gunakan foreach untuk menampilkan detail pembelian dan menghitung total harga per item
                foreach ($transaksi_detail_foreach as $item): 
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['kode']); ?></td>
                    <td><?php echo htmlspecialchars($item['nama']); ?></td>
                    <td class="text-right">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td class="text-right"><?php echo htmlspecialchars($item['jumlah']); ?></td>
                    <td class="text-right">Rp <?php echo number_format($item['total_item'], 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="4">**GRAND TOTAL PEMBELIAN (`$grand_total`)**</td>
                    <td class="text-right">**Rp <?php echo number_format($grand_total_foreach, 0, ',', '.'); ?>**</td>
                </tr>
            </tfoot>
        </table>
        
        <div class="logout-link">
            <a href="logout.php">Keluar (Logout)</a>
        </div>
        </div>
</body>
</html>