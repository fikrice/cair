# StockSell — Alur Aplikasi & Fungsi Tiap User

> Dokumen ini menjelaskan alur kerja aplikasi StockSell dan fungsi masing-masing role user.

---

## Konteks Aplikasi

**StockSell** adalah aplikasi **Inventory & Penjualan** untuk **UKM/SME** (Usaha Kecil Menengah). Aplikasi ini mengelola alur barang dari **pembelian ke supplier** → **masuk gudang** → **penjualan ke customer** → **pencatatan keuangan**.

---

## 4 Role User & Fungsinya

### 1. Admin (`admin@stocksell.com` / password: `password`)

**Jobdesc:** Manage semua, approve/reject PO & SO, buat SO

| Akses | Keterangan |
|-------|-----------|
| Dashboard | Melihat semua statistik (full) |
| User Management | CRUD user (tambah, edit, hapus akun) |
| Product | CRUD produk |
| Category | CRUD kategori |
| Supplier | CRUD supplier |
| Stock | Lihat stok |
| Purchase Order | **Approve/Reject** PO yang dibuat Purchasing |
| Sales Order | **Buat SO** untuk customer |
| Transaction | Lihat transaksi |

**Alur kerja Admin:**
- Menerima PO dari Purchasing → Approve atau Reject
- Membuat Sales Order (SO) untuk customer → dikirim ke Warehouse untuk dicek stok

---

### 2. Finance (`finance@stocksell.com` / password: `password`)

**Jobdesc:** Keuangan, pencatatan pembayaran, laporan

| Akses | Keterangan |
|-------|-----------|
| Dashboard | Statistik keuangan |
| Product | **View only** (lihat harga modal/jual) |
| Transaction | **Full CRUD** - catat pembayaran dari customer |

**Alur kerja Finance:**
- Setelah SO di-approve Warehouse, Finance mencatat pembayaran dari customer
- Membuat laporan penjualan/pembelian/profit

---

### 3. Warehouse (`warehouse@stocksell.com` / password: `password`)

**Jobdesc:** Kelola stok, terima barang PO, approve SO

| Akses | Keterangan |
|-------|-----------|
| Dashboard | Statistik stok |
| Product | CRUD produk |
| Category | CRUD kategori |
| Supplier | **View only** |
| Stock | **Full** - adjustment stok, opname |
| Stock Mutation | Lihat riwayat mutasi stok |
| Purchase Order | **Terima barang** (PO yang sudah approved → update stok masuk) |
| Sales Order | **Approve/Reject** SO (cek ketersediaan stok) |

**Alur kerja Warehouse:**
- PO sudah di-approve Admin → Warehouse terima barang → stok bertambah (mutasi IN)
- SO dibuat Admin → Warehouse cek stok → Approve (stok berkurang/mutasi OUT) atau Reject (stok tidak cukup)
- Melakukan stock opname (rekonsiliasi stok fisik vs sistem)

---

### 4. Purchasing (`purchasing@stocksell.com` / password: `password`)

**Jobdesc:** Buat Purchase Order ke supplier

| Akses | Keterangan |
|-------|-----------|
| Dashboard | Statistik PO |
| Product | **View only** (lihat produk yang perlu di-restock) |
| Supplier | CRUD supplier |
| Purchase Order | **Create/Edit** PO (buat pesanan ke supplier) |

**Alur kerja Purchasing:**
- Lihat produk yang stoknya rendah
- Buat PO ke supplier (pilih supplier, pilih produk, qty, harga)
- Submit PO → dikirim ke Admin untuk approval

---

## Alur Bisnis Lengkap

### Alur Pembelian (Purchase Order)

```
Purchasing          Admin              Warehouse           Sistem
    │                 │                    │                  │
    │── Buat PO ─────▶│                    │                  │
    │  (status:draft)  │                    │                  │
    │                  │                    │                  │
    │── Submit PO ────▶│                    │                  │
    │  (status:pending)│                    │                  │
    │                  │── Approve ────────▶│                  │
    │                  │  (status:approved) │                  │
    │                  │                    │── Terima Barang ─▶│
    │                  │                    │  (status:received)│── Update Stok
    │                  │                    │                   │   (Mutasi IN)
```

### Alur Penjualan (Sales Order)

```
Admin              Warehouse           Finance             Sistem
  │                    │                  │                   │
  │── Buat SO ────────▶│                  │                   │
  │  (status:draft)    │                  │                   │
  │                    │                  │                   │
  │── Submit SO ──────▶│                  │                   │
  │  (status:pending)  │                  │                   │
  │                    │── Approve ──────▶│                   │
  │                    │  (status:approved)│── Update Stok     │
  │                    │                   │   (Mutasi OUT)    │
  │                    │                  │                   │
  │                    │                  │── Catat Bayar ───▶│
  │                    │                  │  (Transaction)    │── Record Payment
```

---

## Akses Matrix per Role

| Modul | Admin | Finance | Warehouse | Purchasing |
|-------|:-----:|:-------:|:---------:|:----------:|
| Dashboard | ✅ Full | ✅ Finance | ✅ Stock | ✅ PO |
| User Management | ✅ CRUD | ❌ | ❌ | ❌ |
| Product | ✅ CRUD | 👁 View | ✅ CRUD | 👁 View |
| Category | ✅ CRUD | ❌ | ✅ CRUD | ❌ |
| Supplier | ✅ CRUD | ❌ | 👁 View | ✅ CRUD |
| Stock | ✅ View | ❌ | ✅ Full | ❌ |
| Stock Mutation | ✅ View | ❌ | ✅ View | ❌ |
| Purchase Order | ✅ Approve/Reject | ❌ | ✅ Receive | ✅ Create/Edit |
| Sales Order | ✅ Create/Edit | ❌ | ✅ Approve/Reject | ❌ |
| Transaction | ✅ View | ✅ Full | ❌ | ❌ |

---

## Status Flow

### Purchase Order Status
```
draft → pending → approved → received
                 ↘ rejected
```

### Sales Order Status
```
draft → pending → approved → completed
                 ↘ rejected
```

---

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 12 (PHP 8.2+) |
| Admin Panel | Filament v5.6.2 |
| Database | MySQL 8.0 |
| Auth | Filament Panel Auth |
| Session | File-based |

---

> **Dibuat oleh:** enowX Labs AI Assistant
> **Tanggal:** 2026
> **Referensi:** BRIEF.md, Skripsi Rendy
