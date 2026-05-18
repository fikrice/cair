# 🚀 Panduan Lengkap Instalasi & Setup Aplikasi - StockSell ERP

Dokumen ini berisi daftar seluruh software yang diperlukan untuk menjalankan aplikasi **StockSell ERP** di sistem operasi Windows, lengkap dengan tautan unduhan resmi (official download links), langkah-langkah instalasi, dan perintah untuk memulai server lokal.

---

## 📦 1. Daftar Software yang Diperlukan & Tautan Unduhan

Untuk kemudahan setup di sistem operasi Windows, kami merekomendasikan penggunaan **Laragon** karena sudah membungkus PHP, MySQL, Apache, dan Composer dalam satu paket ringan yang sangat mudah dikelola. Namun, Anda juga dapat menginstalnya secara terpisah menggunakan **XAMPP**.

### 🌟 Opsi A: Menggunakan Laragon (Sangat Direkomendasikan)
Laragon adalah tool environment lokal terbaik untuk Windows, sangat cepat, ringan, dan minim konflik port.
*   **Laragon Full (PHP 8.1+, MySQL, Apache, Git)**:
    *   **Deskripsi**: Menyediakan runtime PHP, database MySQL, Git, dan Composer secara otomatis.
    *   **Tautan Unduhan**: [Download Laragon Full (Official)](https://laragon.org/download/)

### 📊 Opsi B: Menggunakan XAMPP & Tool Terpisah (Opsi Alternatif)
Jika Anda lebih terbiasa dengan XAMPP, silakan unduh aplikasi berikut secara terpisah:

1.  **PHP 8.1 / 8.2 & MySQL (via XAMPP)**:
    *   **Deskripsi**: Server web Apache + database MySQL + interpreter PHP.
    *   **Tautan Unduhan**: [Download XAMPP PHP 8.1+ (Official)](https://www.apachefriends.org/download.html)
2.  **Composer (PHP Dependency Manager)**:
    *   **Deskripsi**: Mengelola pustaka/library backend PHP (Laravel).
    *   **Tautan Unduhan**: [Download Composer untuk Windows (Official)](https://getcomposer.org/download/)
3.  **Git untuk Windows**:
    *   **Deskripsi**: Alat version control untuk clone dan manajemen kode sumber.
    *   **Tautan Unduhan**: [Download Git for Windows (Official)](https://git-scm.com/download/win)

---

### 🌐 Tool Pendukung Wajib (Untuk Aset Frontend & Editor)

1.  **Node.js & npm (LTS Version - v18 atau v20)**:
    *   **Deskripsi**: Diperlukan untuk kompilasi modul frontend, menjalankan bundler **Vite**, dan memuat asset CSS/JavaScript.
    *   **Tautan Unduhan**: [Download Node.js LTS (Official)](https://nodejs.org/en/download/)
2.  **Visual Studio Code (Editor Kode)**:
    *   **Deskripsi**: Text editor terbaik untuk memodifikasi atau meninjau kode.
    *   **Tautan Unduhan**: [Download VS Code (Official)](https://code.visualstudio.com/download)

---

## 🛠️ 2. Langkah-Langkah Setup Aplikasi dari Nol

Setelah semua software di atas diinstal, ikuti langkah-langkah berikut di terminal (PowerShell / Command Prompt) pada direktori proyek Anda:

### Langkah 1: Gandakan / Salin File Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env` di folder utama aplikasi:
```bash
copy .env.example .env
```
Buka file `.env` menggunakan VS Code dan sesuaikan konfigurasi database Anda (biasanya bawaan Laragon/XAMPP adalah):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stocksell_db
DB_USERNAME=root
DB_PASSWORD=
```
*Catatan: Pastikan Anda telah membuat database kosong bernama `stocksell_db` melalui phpMyAdmin (`http://localhost/phpmyadmin`) atau database manager bawaan Laragon.*

### Langkah 2: Instal Dependensi Backend (Composer)
Unduh seluruh library Laravel yang dibutuhkan dengan perintah:
```bash
composer install
```

### Langkah 3: Generate Application Key
Generate key enkripsi unik untuk keamanan aplikasi Anda:
```bash
php artisan key:generate
```

### Langkah 4: Jalankan Migrasi & Suntik Master Data (Seeder)
Buat struktur tabel di database Anda dan isi data dasar User Bawaan, Kategori, serta Produk secara otomatis:
```bash
php artisan migrate:fresh --seed
```
*Perintah di atas akan mengosongkan database dan langsung mengisinya dengan 50 produk, 5 kategori utama, dan 4 akun siap pakai.*

### Langkah 5: Instal Dependensi Frontend (Node.js)
Unduh seluruh library JavaScript/CSS yang digunakan untuk tampilan antarmuka:
```bash
npm install
```

---

## 🚀 3. Cara Menjalankan Aplikasi di Lokal

Aplikasi Laravel 10 menggunakan Vite sebagai bundler aset frontend. Untuk menjalankannya secara lokal, Anda perlu **membuka dua jendela terminal** dan menjalankan kedua perintah berikut secara bersamaan:

### 🖥️ Terminal 1: Menjalankan Server Backend PHP
Perintah ini berguna untuk melayani request PHP dan database:
```bash
php artisan serve
```
*Aplikasi akan berjalan di alamat:* **`http://127.0.0.1:8000`**

### ⚡ Terminal 2: Menjalankan Compiler Aset Frontend (Vite)
Perintah ini berguna untuk memuat file CSS, ikon Tailwind/Bootstrap, dan logika JavaScript agar tampilan dashboard tampil sempurna:
```bash
npm run dev
```

---

## 🔑 4. Informasi Akun Bawaan untuk Login

Gunakan akun siap pakai berikut untuk masuk ke dashboard sesuai role yang ingin diuji:

| Role Pengguna | Email Login | Password | Fungsi Akses |
| :--- | :--- | :--- | :--- |
| **Admin (Supervisor)** | `admin@mesama.com` | `password` | Kendali penuh (SO, Produk, Kategori, Log Stok, User) |
| **Finance (Keuangan)** | `finance@mesama.com` | `password` | Pembayaran SO & PO, Piutang/Utang, Dashboard Kas |
| **Warehouse (Gudang)** | `warehouse@mesama.com` | `password` | Pengiriman SO, Penerimaan PO, Log Stok (Penyesuaian diblokir) |
| **Purchasing (Pembelian)**| `purchasing@mesama.com`| `password` | Pengajuan Purchase Order (PO) ke Supplier |

---

*Panduan ini dibuat secara rinci untuk memastikan kelancaran operasional tim teknis dan klien PT Mesama Global Indonesia.*
