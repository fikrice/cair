# Panduan Pengguna StockSell ERP

Selamat datang di panduan operasional **StockSell**. Dokumen ini menjelaskan cara menggunakan fitur-fitur utama sistem berdasarkan peran (role) Anda.

---

## 1. Memulai (Getting Started)
Akses aplikasi melalui browser (default: `http://localhost:8000`). Gunakan akun yang sesuai dengan departemen Anda untuk melihat dashboard yang relevan.

---

## 2. Alur Pembelian Barang (Modul Purchasing)
Gunakan modul ini jika Anda perlu menambah stok barang dari supplier.

1.  **Masuk sebagai Purchasing**: Cek dashboard untuk melihat produk dengan status "Stok Kritis".
2.  **Buat Purchase Order (PO)**: 
    - Klik menu **"Purchase Orders"** → **"Buat PO Baru"**.
    - Pilih Supplier, tentukan produk, jumlah, dan harga beli.
    - Simpan sebagai **"Submit"** (Status: `pending`).
3.  **Pelunasan Finance (Finance)**:
    - Finance memvalidasi tagihan dari supplier untuk PO yang berstatus `pending`.
    - Klik **"Bayar Tagihan"** untuk melunasi tagihan supplier terlebih dahulu (Status pembayaran: `paid`).
4.  **Penerimaan di Gudang (Warehouse)**: 
    - Warehouse memantau PO yang sudah lunas dibayar oleh Finance.
    - Setelah barang fisik tiba dari supplier, Warehouse klik **"Konfirmasi Terima"** (Status PO berubah menjadi `received`).
    - Stok barang di sistem bertambah otomatis dan tercatat di Log Pergerakan Stok.

---

## 3. Alur Penjualan Barang (Modul Sales)
Gunakan modul ini untuk melayani pesanan pelanggan.

1.  **Admin Membuat Pesanan**: 
    - Klik menu **"Sales Orders"** → **"Buat SO Baru"**.
    - Masukkan nama customer dan pilih produk yang dipesan.
    - Klik **"Simpan"**. Status SO menjadi `processing` dan status pembayaran `unpaid`.
2.  **Pembayaran Finance**: 
    - Finance melihat pesanan masuk di menu **"Tagihan & Faktur"**.
    - Setelah pelanggan melunasi pembayaran, Finance klik **"Bayar Sekarang"** (Status pembayaran: `paid`). Status SO tetap `processing`.
3.  **Pengiriman Warehouse**: 
    - Warehouse melihat pesanan yang sudah lunas dibayar oleh customer di menu **"Pengiriman Barang"**.
    - Gudang menyiapkan barang secara fisik, lalu klik **"Siapkan & Kirim Barang"**.
    - Stok otomatis berkurang di sistem, dan status SO selesai (`completed`).

---

## 4. Manajemen Stok & Gudang
Dikelola oleh role **Warehouse**:

-   **Data Produk**: Tempat mengelola SKU, nama barang, dan kategori.
-   **Log Pergerakan**: Riwayat otomatis setiap kali ada barang masuk (PO) atau keluar (SO).
-   **Penyesuaian Stok (Adjustment)**: Digunakan jika ada barang rusak atau selisih stok fisik tanpa melalui jalur PO/SO. Pastikan menulis alasan yang jelas.

---

## 5. Laporan & Keuangan
Dikelola oleh role **Finance** & **Admin**:

-   **Dashboard Keuangan**: Pantau arus kas (Cash In vs Cash Out) dan estimasi laba kotor secara real-time.
-   **Laporan Belanja**: Detail pengeluaran perusahaan ke supplier.
-   **Laporan Pendapatan**: Detail uang masuk dari hasil penjualan.
-   **Cetak Invoice**: Di setiap detail pesanan, terdapat tombol **"Cetak Invoice"** untuk bukti transaksi.

---

## 6. Tips Penggunaan
-   **Pencarian Cepat**: Gunakan kotak pencarian di setiap tabel untuk menemukan data SKU atau Nomor PO/SO secara instan.
-   **Sidebar Responsif**: Klik ikon menu di pojok kiri atas untuk menyembunyikan sidebar agar tampilan tabel lebih luas.
-   **Indikator Badge**: Perhatikan angka merah/kuning di sidebar. Itu menandakan ada tugas yang butuh perhatian segera (PO belum diapprove atau SO belum dikonfirmasi).

---
*StockSell ERP — Solusi Cerdas Manajemen Inventaris Anda.*
