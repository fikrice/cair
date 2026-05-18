# StockSell — Modern Inventory & Sales ERP System

**StockSell** adalah sistem ERP (Enterprise Resource Planning) berbasis web yang dirancang untuk membantu UKM/SME dalam mengelola inventaris, pembelian barang, penjualan, hingga laporan keuangan secara real-time. Dibangun dengan **Laravel 12** dan **Tailwind CSS**, StockSell menawarkan antarmuka premium **TailAdmin** yang intuitif dan responsif.

---

## 🚀 Fitur Utama

-   **Dashboard Multi-Role**: Visualisasi data unik untuk setiap departemen (Admin, Finance, Warehouse, Purchasing).
-   **Manajemen Inventaris**: Pelacakan stok otomatis, peringatan stok rendah, dan log mutasi barang.
-   **Alur Pembelian (PO)**: Siklus pengadaan barang dari pembuatan draft hingga penerimaan di gudang.
-   **Alur Penjualan (SO)**: Manajemen pesanan pelanggan dengan sistem validasi stok otomatis.
-   **Pusat Keuangan**: Pencatatan transaksi, manajemen tagihan (invoice), dan laporan laba-rugi otomatis.
-   **Laporan & Analitik**: Ekspor laporan ke PDF dan visualisasi tren penjualan/pembelian.

---

## 👥 Peran Pengguna (Roles) & Fungsi

Sistem ini menggunakan pembagian hak akses (RBAC) untuk memastikan efisiensi kerja:

### 1. Admin (Pusat Kendali)
-   **Fungsi**: Mengawasi seluruh operasional perusahaan.
-   **Tugas**: Mengelola akun pengguna, konfigurasi sistem, dan membuat pesanan penjualan (Sales Order).
-   **Akses**: Semua modul (Full Access).

### 2. Purchasing (Pengadaan)
-   **Fungsi**: Bertanggung jawab atas stok yang masuk dari pemasok.
-   **Tugas**: Memantau stok rendah, mengelola data supplier, dan membuat Purchase Order (PO).
-   **Akses**: Dashboard Purchasing, Supplier, dan Purchase Orders.

### 3. Warehouse (Gudang & Logistik)
-   **Fungsi**: Mengelola pergerakan fisik barang.
-   **Tugas**: Mengonfirmasi penerimaan barang (PO), melakukan validasi pengiriman barang (SO), dan penyesuaian stok (*Stock Adjustment*).
-   **Akses**: Dashboard Logistik, Produk, Kategori, Stok, dan Validasi PO/SO.

### 4. Finance (Keuangan)
-   **Fungsi**: Mengelola arus kas dan validasi pembayaran.
-   **Tugas**: Memvalidasi pembayaran invoice dari customer, memantau piutang, dan menarik laporan keuangan.
-   **Akses**: Dashboard Keuangan, Transaksi, dan Laporan (Revenue/Expense).

---

## 🔄 Alur Kerja Sistem (Workflow)

### A. Alur Pengadaan Barang (Purchase Order)
1.  **Purchasing**: Membuat PO baru ke supplier (Status: *Pending*, Pembayaran: *Belum Bayar*).
2.  **Finance**: Membayar pelunasan tagihan supplier terlebih dahulu (Pembayaran: *Lunas*). Status PO tetap *Pending*.
3.  **Warehouse**: Memantau PO yang sudah lunas dibayar → Menerima barang fisik di gudang → Konfirmasi penerimaan (Status: *Received*).
4.  **Sistem**: Otomatis menambah stok produk dan mencatat riwayat pengeluaran setelah konfirmasi terima barang.

### B. Alur Penjualan Barang (Sales Order)
1.  **Admin**: Membuat SO untuk pelanggan (Status: *Processing*, Pembayaran: *Belum Bayar*).
2.  **Finance**: Mencatat pembayaran dari pelanggan terlebih dahulu → Melakukan pelunasan pembayaran (Pembayaran: *Lunas*). Status SO tetap *Processing*.
3.  **Warehouse**: Memantau SO yang sudah lunas dibayar → Memotong stok barang fisik → Melakukan pengiriman barang (Status: *Completed*).
4.  **Sistem**: Otomatis mengurangi stok produk dan mencatat mutasi keluar setelah konfirmasi pengiriman barang.

---

## 🛠️ Instalasi

Ikuti langkah berikut untuk menjalankan project di lingkungan lokal:

1.  **Clone Repository**
    ```bash
    git clone https://github.com/username/stocksell.git
    cd stocksell
    ```

2.  **Instal Dependensi**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**
    Salin `.env.example` ke `.env` dan sesuaikan kredensial database Anda.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Migrasi & Seeding** (Penting untuk membuat akun default)
    ```bash
    php artisan migrate --seed
    ```

5.  **Jalankan Aplikasi**
    ```bash
    php artisan serve
    npm run dev
    ```

---

## 📝 Akun Demo Default
-   **Admin**: `admin@stocksell.com` | `password`
-   **Finance**: `finance@stocksell.com` | `password`
-   **Warehouse**: `warehouse@stocksell.com` | `password`
-   **Purchasing**: `purchasing@stocksell.com` | `password`

---

## 💻 Tech Stack
-   **Framework**: Laravel 12
-   **Styling**: Tailwind CSS v4
-   **Icons**: Lucide Icons
-   **Charts**: ApexCharts.js
-   **Database**: MySQL / SQLite

---
*Dibuat untuk memodernisasi manajemen operasional UKM.*
