<?php
// Array 2 dimensi: [kode_barang, nama, harga]
$barang_list = [
    ["K001", "Semangka", 35000],
    ["K002", "Nanas", 25000],
    ["K003", "Pisang", 20000],
    ["K004", "Alpukat", 21000],
    ["K005", "Jeruk", 22000],
];

$belanja = [];
$grandtotal = 0;

// Pilih jumlah barang acak (2–5)
$jumlah_item = rand(2, 5);
$pilih_index = array_rand($barang_list, $jumlah_item);

if (!is_array($pilih_index)) {
    $pilih_index = [$pilih_index];
}

// Buat daftar belanja dari array 2 dimensi
foreach ($pilih_index as $idx) {
    $barang = $barang_list[$idx]; // [kode, nama, harga]
    $jumlah = rand(1, 5);
    $subtotal = $barang[2] * $jumlah;
    $belanja[] = [$barang[0], $barang[1], $barang[2], $jumlah, $subtotal];
    $grandtotal += $subtotal;
}

$diskon = 0;
if ($grandtotal > 100000) {
    $diskon = 0.10 * $grandtotal; // Diskon 10%
}
$total_akhir = $grandtotal - $diskon;

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Halaman Dashboard</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      background: #f5f8ff;
      color: #333;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #fff;
      padding: 1rem 2rem;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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
      border-radius: 50%;
      width: 40px;
      height: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .title h2 {
      font-size: 1.2rem;
      color: #1a57e2;
    }

    .title p {
      font-size: 0.8rem;
      color: #777;
    }

    .content {
      background: #fff;
      margin: 2rem auto;
      padding: 2rem;
      width: 90%;
      max-width: 800px;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.05);
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    th, td {
      border-bottom: 1px solid #e6e6e6;
      padding: 10px;
      text-align: left;
    }

    th {
      background: #f8f9fc;
      font-weight: 600;
    }

    tfoot td {
      font-weight: 600;
      border-top: 2px solid #ccc;
      text-align: right;
    }

    .total-value {
      color: #1a57e2;
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
      <p>Selamat datang, <strong>admin!</strong><br>
      <span class="role">Role: Dosen</span></p>
      <a href="logout.php" class="btn btn-primary">logout</a>
    </div>
  </header>

  <main class="content">
    <h3>Daftar Pembelian</h3>
    <p class="subtext">Daftar pembelian dibuat secara acak tiap kali halaman dimuat</p>

    <table>
      <thead>
        <tr>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($belanja as $item): ?>
        <tr>
          <td><?= $item[0]; ?></td>
          <td><?= $item[1]; ?></td>
          <td>Rp <?= number_format($item[2], 0, ',', '.'); ?></td>
          <td><?= $item[3]; ?></td>
          <td>Rp <?= number_format($item[4], 0, ',', '.'); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
  <tr>
    <td colspan="4">Total Belanja</td>
    <td class="total-value">Rp <?= number_format($grandtotal, 0, ',', '.'); ?></td>
  </tr>

  <tr>
    <td colspan="4">Diskon (10%)</td>
    <td class="total-value">Rp <?= number_format($diskon, 0, ',', '.'); ?></td>
  </tr>

  <tr>
    <td colspan="4">Total Akhir</td>
    <td class="total-value"><strong>Rp <?= number_format($total_akhir, 0, ',', '.'); ?></strong></td>
  </tr>
</tfoot>

      </tfoot>
    </table>
  </main>
</body>
</html>
