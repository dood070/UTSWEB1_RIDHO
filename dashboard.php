<?php

$barang_list = [
    ["K001", "Semangka", 35000],
    ["K002", "Nanas", 25000],
    ["K003", "Pisang", 20000],
    ["K004", "Alpukat", 21000],
    ["K005", "Jeruk", 22000],
];

// DATA PEMBELIAN AWAL DIBUAT KOSONG DAN TOTAL DISET KE NOL
$belanja_awal = [];
$grandtotal_awal = 0;
$diskon_awal = 0;
$total_akhir_awal = 0;


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
        /* --- CSS (Sama seperti sebelumnya) --- */
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
        <div class="input-form">
            <div class="form-group">
                <label for="kode_barang">Kode Barang</label>
                <input type="text" id="kode_barang" placeholder="Masukkan Kode Barang">
            </div>
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" placeholder="Masukkan Nama Barang">
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" id="harga" placeholder="Masukkan Harga" step="1000" min="0">
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" id="jumlah" placeholder="Masukkan Jumlah" min="1">
            </div>
            <div class="actions">
                <button class="btn btn-primary" id="btn-tambah">Tambahkan</button>
                <button class="btn btn-secondary" id="btn-batal">Batal</button>
            </div>
        </div>

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
                <?php foreach ($belanja_awal as $item): ?>
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
                <td class="summary-value" id="total-belanja-value"><?= format_rupiah($grandtotal_awal); ?></td>
            </tr>

            <tr>
                <td class="summary-label">Diskon</td>
                <td class="summary-value" id="diskon-value"><?= get_diskon_text($diskon_awal, $grandtotal_awal); ?></td>
            </tr>

            <tr>
                <td class="summary-label">Total Bayar</td>
                <td class="summary-value total-pay-value" id="total-bayar-value">**<?= format_rupiah($total_akhir_awal); ?>**</td>
            </tr>
        </table>

        <div style="margin-top: 15px;">
             <button class="btn empty-cart-btn" id="btn-kosongkan">Kosongkan Keranjang</button>
        </div>
    </main>

    <script>
        // --- Bagian JavaScript untuk Interaktivitas ---
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Ambil semua elemen yang dibutuhkan
            const kodeInput = document.getElementById('kode_barang');
            const namaInput = document.getElementById('nama_barang');
            const hargaInput = document.getElementById('harga');
            const jumlahInput = document.getElementById('jumlah');
            const btnTambah = document.getElementById('btn-tambah');
            const btnBatal = document.getElementById('btn-batal');
            const btnKosongkan = document.getElementById('btn-kosongkan');
            const daftarBody = document.getElementById('daftar-pembelian-body');
            const totalBelanjaEl = document.getElementById('total-belanja-value');
            const diskonEl = document.getElementById('diskon-value');
            const totalBayarEl = document.getElementById('total-bayar-value');

            // 2. Data Barang (Digunakan untuk Autocomplete/Validasi)
            const barangReferensi = <?= json_encode($barang_list); ?>;

            // 3. Fungsi Utility
            const formatRupiah = (angka) => {
                return "Rp " + new Intl.NumberFormat('id-ID').format(angka);
            };

            const calculateDiscount = (total) => {
                // Diskon 10% jika total > Rp 100.000
                if (total > 100000) {
                    const diskon = total * 0.10;
                    return { diskon: diskon, persen: 10 };
                }
                return { diskon: 0, persen: 0 };
            };

            const getDiskonText = (diskon, persen) => {
                if (diskon === 0) return formatRupiah(0);
                return formatRupiah(diskon) + (persen > 0 ? ` (${persen}%)` : "");
            };

            const hitungUlangTotal = () => {
                let grandTotal = 0;
                // Ambil semua baris di tabel dan tambahkan subtotalnya
                daftarBody.querySelectorAll('tr').forEach(row => {
                    const subtotalAttr = row.getAttribute('data-subtotal');
                    if(subtotalAttr) {
                        grandTotal += parseInt(subtotalAttr);
                    }
                });

                const { diskon, persen } = calculateDiscount(grandTotal);
                const totalAkhir = grandTotal - diskon;

                // Perbarui tampilan
                totalBelanjaEl.textContent = formatRupiah(grandTotal);
                diskonEl.textContent = getDiskonText(diskon, persen);
                totalBayarEl.innerHTML = `**${formatRupiah(totalAkhir)}**`;
            };
            
            // Panggil hitungUlangTotal untuk memastikan total awal benar (Rp 0)
            // Ini tetap diperlukan untuk menyinkronkan tampilan meskipun PHP sudah mengesetnya ke 0
            hitungUlangTotal();


            // 4. Event Listener Tombol "Tambahkan"
            btnTambah.addEventListener('click', function() {
                const kode = kodeInput.value.trim();
                const nama = namaInput.value.trim();
                const harga = parseInt(hargaInput.value) || 0;
                const jumlah = parseInt(jumlahInput.value) || 0;

                // Validasi Input
                if (!kode || !nama || harga <= 0 || jumlah <= 0) {
                    alert('Mohon lengkapi data barang dengan benar!');
                    return;
                }

                const subtotal = harga * jumlah;

                // Buat baris baru untuk tabel
                const newRow = document.createElement('tr');
                newRow.setAttribute('data-subtotal', subtotal);
                newRow.innerHTML = `
                    <td>${kode}</td>
                    <td>${nama}</td>
                    <td class="harga-satuan" data-harga="${harga}">${formatRupiah(harga)}</td>
                    <td>${jumlah}</td>
                    <td class="subtotal-item" style="text-align: right;">${formatRupiah(subtotal)}</td>
                `;

                // Masukkan baris baru ke tabel
                daftarBody.appendChild(newRow);

                // Hitung ulang total belanja
                hitungUlangTotal();

                // Kosongkan input
                clearInputs();
            });

            // 5. Event Listener Tombol "Batal"
            btnBatal.addEventListener('click', function() {
                clearInputs();
            });

            const clearInputs = () => {
                kodeInput.value = '';
                namaInput.value = '';
                hargaInput.value = '';
                jumlahInput.value = '';
                kodeInput.focus(); 
            };

            // 6. Event Listener Tombol "Kosongkan Keranjang"
            btnKosongkan.addEventListener('click', function() {
                if (confirm("Anda yakin ingin mengosongkan keranjang pembelian?")) {
                    daftarBody.innerHTML = ''; // Hapus semua baris
                    hitungUlangTotal(); // Hitung ulang total (akan menjadi Rp 0)
                }
            });

            // OPTIONAL: Fitur Autocomplete Sederhana berdasarkan Kode
            kodeInput.addEventListener('change', function() {
                const kodeCari = kodeInput.value.trim();
                const item = barangReferensi.find(b => b[0] === kodeCari);

                if (item) {
                    namaInput.value = item[1];
                    hargaInput.value = item[2];
                    jumlahInput.focus();
                } else {
                    namaInput.value = '';
                    hargaInput.value = '';
                }
            });
        });
    </script>
</body>
</html>