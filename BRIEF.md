# StockSell — Brief Aplikasi Inventory & Penjualan

> Dokumen ini berisi ringkasan kebutuhan, arsitektur, dan rencana pengembangan aplikasi **StockSell** berbasis Laravel 11.

---

## 1. Project Overview

| Item | Detail |
|------|--------|
| **Project Name** | StockSell |
| **Type** | Web Application (Inventory & Penjualan) |
| **Tech Stack** | Laravel 11, MySQL, Blade + TailwindCSS |
| **Target User** | UKM / SME (Gudang & Penjualan) |

---

## 2. Struktur User & Akses

| Role | Jobdesc | Akses Modul |
|------|---------|-------------|
| **Admin** | Manage user, approve/reject PO & SO, buat SO | Semua modul |
| **Finance** | Keuangan, laporan | Transaction, Finance/Reporting, Dashboard |
| **Warehouse** | Stok, approve SO, terima barang PO | Stock, Product, Category, SO (approve), PO (terima) |
| **Purchasing** | Buat PO ke supplier | Purchase Order, Supplier, Dashboard |

---

## 3. Functional Requirements (10 Modul)

### FR-01: User Management (Admin Only)

| Kode | Fitur | Keterangan |
|------|-------|------------|
| FR-01.1 | Tampilkan daftar user | Tabel user dengan pagination |
| FR-01.2 | Tambah user baru | Form: nama, email, password, role, phone |
| FR-01.3 | Edit data user | Update nama, email, role, phone |
| FR-01.4 | Hapus user | Soft delete |
| FR-01.5 | Cari user | Search by nama/email |

### FR-02: Product Management

| Kode | Fitur | Keterangan |
|------|-------|------------|
| FR-02.1 | Tampilkan daftar produk | Tabel produk + pagination |
| FR-02.2 | Tambah produk baru | Form: nama, SKU, harga modal, harga jual, kategori, unit, min_stock |
| FR-02.3 | Edit produk | Update semua field |
| FR-02.4 | Hapus produk | Soft delete (cek relasi stok) |
| FR-02.5 | Cari produk | Search by nama/SKU |
| FR-02.6 | Filter by kategori | Dropdown filter |
| FR-02.7 | Detail produk | View detail + riwayat mutasi stok |

### FR-03: Category Management

| Kode | Fitur | Keterangan |
|------|-------|------------|
| FR-03.1 | Tampilkan daftar kategori | Tabel kategori |
| FR-03.2 | Tambah kategori | Form: nama, deskripsi |
| FR-03.3 | Edit kategori | Update nama, deskripsi |
| FR-03.4 | Hapus kategori | Cek relasi produk sebelum hapus |
| FR-03.5 | Cari kategori | Search by nama |

### FR-04: Supplier Management

| Kode | Fitur | Keterangan |
|------|-------|------------|
| FR-04.1 | Tampilkan daftar supplier | Tabel supplier + pagination |
| FR-04.2 | Tambah supplier | Form: nama, alamat, phone, email |
| FR-04.3 | Edit supplier | Update semua field |
| FR-04.4 | Hapus supplier | Cek relasi PO sebelum hapus |
| FR-04.5 | Cari supplier | Search by nama |

### FR-05: Stock Management (Warehouse)

| Kode | Fitur | Keterangan |
|------|-------|------------|
| FR-05.1 | Tampilkan daftar stok | Tabel stok per produk |
| FR-05.2 | Adjustment stok | Manual adjust (tambah/kurang) dengan catatan |
| FR-05.3 | View mutasi stok | Riwayat semua pergerakan stok (in/out/adjustment/opname) |
| FR-05.4 | Filter stok by produk | Dropdown/search filter |
| FR-05.5 | Alert stok minimum | Notifikasi jika stok < min_stock |
| FR-05.6 | Stock opname | Rekonsiliasi stok fisik vs sistem |

### FR-06: Purchase Order (Purchasing → Admin → Warehouse)

| Kode | Fitur | Keterangan |
|------|-------|------------|
| FR-06.1 | Tampilkan daftar PO | Tabel PO + filter status |
| FR-06.2 | Buat PO (Purchasing) | Pilih supplier, tambah item produk + qty + harga |
| FR-06.3 | Approve PO (Admin) | Admin setujui PO → status: approved |
| FR-06.4 | Reject PO (Admin) | Admin tolak PO → status: rejected + alasan |
| FR-06.5 | Terima barang (Warehouse) | Warehouse konfirmasi barang diterima → update stok (mutasi in) |
| FR-06.6 | Hapus PO | Hanya PO berstatus draft |
| FR-06.7 | Filter PO by status | Filter: draft, pending, approved, rejected, received |

**Alur PO:**
```
Purchasing         Admin              Warehouse           Sistem
    │                 │                    │                  │
    │── Buat PO ─────▶│                    │                  │
    │  (status:draft)  │                    │                  │
    │                  │── Approve ────────▶│                  │
    │                  │  (status:approved) │                  │
    │                  │                    │── Terima Barang ─▶│
    │                  │                    │  (status:received)│── Update Stok
    │                  │                    │                   │   (Mutasi In)
```

### FR-07: Sales Order (Admin → Warehouse → Konfirmasi)

| Kode | Fitur | Keterangan |
|------|-------|------------|
| FR-07.1 | Tampilkan daftar SO | Tabel SO + filter status |
| FR-07.2 | Buat SO (Admin) | Pilih produk, qty, customer name/phone |
| FR-07.3 | Approve SO (Warehouse) | Warehouse cek ketersediaan stok → approve |
| FR-07.4 | Reject SO (Warehouse) | Warehouse tolak jika stok tidak cukup + alasan |
| FR-07.5 | Hapus SO | Hanya SO berstatus draft |

**Alur SO:**
```
Admin              Warehouse           Sistem
  │                    │                  │
  │── Buat SO ────────▶│                  │
  │  (status:draft)    │                  │
  │                    │── Approve ──────▶│
  │                    │  (status:approved)│── Update Stok
  │                    │                   │   (Mutasi Out)
  │                    │                   │
  │                    │── OR Reject ─────▶│
  │                    │  (status:rejected)│   (No stok change)
```

### FR-08: Transaction (Finance)

| Kode | Fitur | Keterangan |
|------|-------|------------|
| FR-08.1 | Tampilkan daftar transaksi | Tabel transaksi + pagination |
| FR-08.2 | Tambah transaksi | Pembayaran untuk SO yang sudah approved |
| FR-08.3 | Detail transaksi | View detail pembayaran + SO terkait |
| FR-08.4 | Filter by tanggal | Date range picker |
| FR-08.5 | Filter by metode bayar | cash, transfer, e-wallet |

### FR-09: Finance / Reporting (Finance)

| Kode | Fitur | Keterangan |
|------|-------|------------|
| FR-09.1 | Laporan penjualan | Per hari / minggu / bulan, total revenue |
| FR-09.2 | Laporan pembelian | Per PO, total pengeluaran |
| FR-09.3 | Laporan profit | Revenue - Cost (harga jual - harga modal) |
| FR-09.4 | Export PDF | Download laporan dalam format PDF |

### FR-10: Dashboard

| Kode | Fitur | Keterangan |
|------|-------|------------|
| FR-10.1 | Chart penjualan | Grafik penjualan 7/30 hari terakhir |
| FR-10.2 | Chart pembelian | Grafik pembelian 7/30 hari terakhir |
| FR-10.3 | Quick stats | Total produk, stok rendah, PO pending, SO pending |
| FR-10.4 | Dashboard per role | Setiap role melihat data sesuai aksesnya |

---

## 4. Non-Functional Requirements

| Kode | Requirement | Target |
|------|-------------|--------|
| NFR-01 | **Responsive** | Mobile + Desktop (TailwindCSS responsive) |
| NFR-02 | **Response Time** | < 3 detik per halaman |
| NFR-03 | **Security** | Auth Laravel, middleware role-based, CSRF protection |
| NFR-04 | **Browser Support** | Chrome, Firefox, Edge, Safari |
| NFR-05 | **Data Integrity** | Foreign key constraints, soft delete |

---

## 5. Database Schema

### `users`

| Column | Type | Keterangan |
|--------|------|------------|
| id | bigint | PK, auto increment |
| name | varchar(255) | Nama user |
| email | varchar(255) | Unique |
| password | varchar(255) | Hashed (bcrypt) |
| role | enum | admin, finance, warehouse, purchasing |
| phone | varchar(20) | Nullable |
| created_at | timestamp | |
| updated_at | timestamp | |
| deleted_at | timestamp | Soft delete |

### `categories`

| Column | Type | Keterangan |
|--------|------|------------|
| id | bigint | PK |
| name | varchar(255) | Nama kategori |
| description | text | Nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

### `products`

| Column | Type | Keterangan |
|--------|------|------------|
| id | bigint | PK |
| category_id | bigint | FK → categories |
| name | varchar(255) | Nama produk |
| sku | varchar(100) | Unique, kode produk |
| buy_price | decimal(15,2) | Harga modal |
| sell_price | decimal(15,2) | Harga jual |
| min_stock | int | Batas minimum stok alert |
| unit | varchar(50) | pcs, kg, box, liter, dll |
| description | text | Nullable |
| created_at | timestamp | |
| updated_at | timestamp | |
| deleted_at | timestamp | Soft delete |

### `suppliers`

| Column | Type | Keterangan |
|--------|------|------------|
| id | bigint | PK |
| name | varchar(255) | Nama supplier |
| address | text | Alamat lengkap |
| phone | varchar(20) | Nomor telepon |
| email | varchar(255) | Nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

### `stocks`

| Column | Type | Keterangan |
|--------|------|------------|
| id | bigint | PK |
| product_id | bigint | FK → products (unique) |
| quantity | int | Jumlah stok saat ini |
| updated_at | timestamp | |

### `stock_mutations`

| Column | Type | Keterangan |
|--------|------|------------|
| id | bigint | PK |
| product_id | bigint | FK → products |
| type | enum | in, out, adjustment, opname |
| quantity | int | Jumlah mutasi (+/-) |
| reference_type | varchar(50) | PurchaseOrder / SalesOrder / Manual |
| reference_id | bigint | Nullable, ID dari PO/SO |
| note | text | Keterangan mutasi |
| created_by | bigint | FK → users |
| created_at | timestamp | |

### `purchase_orders`

| Column | Type | Keterangan |
|--------|------|------------|
| id | bigint | PK |
| po_number | varchar(50) | Unique, auto-generate (PO-YYYYMMDD-XXX) |
| supplier_id | bigint | FK → suppliers |
| status | enum | draft, pending, approved, rejected, received |
| total_amount | decimal(15,2) | Total harga semua item |
| note | text | Nullable |
| rejection_reason | text | Nullable, alasan reject |
| created_by | bigint | FK → users (Purchasing) |
| approved_by | bigint | FK → users (Admin), Nullable |
| received_by | bigint | FK → users (Warehouse), Nullable |
| approved_at | timestamp | Nullable |
| received_at | timestamp | Nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

### `purchase_order_items`

| Column | Type | Keterangan |
|--------|------|------------|
| id | bigint | PK |
| purchase_order_id | bigint | FK → purchase_orders |
| product_id | bigint | FK → products |
| quantity | int | Jumlah pesan |
| price | decimal(15,2) | Harga per unit |
| subtotal | decimal(15,2) | quantity × price |

### `sales_orders`

| Column | Type | Keterangan |
|--------|------|------------|
| id | bigint | PK |
| so_number | varchar(50) | Unique, auto-generate (SO-YYYYMMDD-XXX) |
| customer_name | varchar(255) | Nama customer |
| customer_phone | varchar(20) | Nullable |
| status | enum | draft, pending, approved, rejected, completed |
| total_amount | decimal(15,2) | Total harga semua item |
| note | text | Nullable |
| rejection_reason | text | Nullable, alasan reject |
| created_by | bigint | FK → users (Admin) |
| approved_by | bigint | FK → users (Warehouse), Nullable |
| approved_at | timestamp | Nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

### `sales_order_items`

| Column | Type | Keterangan |
|--------|------|------------|
| id | bigint | PK |
| sales_order_id | bigint | FK → sales_orders |
| product_id | bigint | FK → products |
| quantity | int | Jumlah jual |
| price | decimal(15,2) | Harga jual per unit |
| subtotal | decimal(15,2) | quantity × price |

### `transactions`

| Column | Type | Keterangan |
|--------|------|------------|
| id | bigint | PK |
| sales_order_id | bigint | FK → sales_orders |
| amount | decimal(15,2) | Jumlah bayar |
| payment_method | enum | cash, transfer, e-wallet |
| payment_date | date | Tanggal bayar |
| note | text | Nullable |
| created_by | bigint | FK → users |
| created_at | timestamp | |
| updated_at | timestamp | |

---

## 6. Akses Matrix per Role

| Modul | Admin | Finance | Warehouse | Purchasing |
|-------|:-----:|:-------:|:---------:|:----------:|
| Dashboard | ✅ Full | ✅ Finance | ✅ Stock | ✅ PO |
| User Management | ✅ CRUD | ❌ | ❌ | ❌ |
| Product | ✅ CRUD | 👁 View | ✅ CRUD | 👁 View |
| Category | ✅ CRUD | ❌ | ✅ CRUD | ❌ |
| Supplier | ✅ CRUD | ❌ | 👁 View | ✅ CRUD |
| Stock | ✅ View | ❌ | ✅ Full | ❌ |
| Purchase Order | ✅ Approve/Reject | ❌ | ✅ Receive | ✅ Create/Edit |
| Sales Order | ✅ Create/Edit | ❌ | ✅ Approve/Reject | ❌ |
| Transaction | ✅ View | ✅ Full | ❌ | ❌ |
| Report | ✅ Full | ✅ Full | ❌ | ❌ |

---

## 7. Prioritas Development (Sprint Plan)

### Sprint 1 — Foundation (Week 1-2)

- [ ] Setup Laravel 11 + TailwindCSS + Breeze
- [ ] Auth (Login/Logout) + Middleware Role-Based
- [ ] Layout (Sidebar, Navbar, responsive)
- [ ] User Management CRUD (Admin)
- [ ] Category CRUD
- [ ] Product CRUD (+ relasi kategori)
- [ ] Supplier CRUD

### Sprint 2 — Core Business Logic (Week 3-4)

- [ ] Stock Management (view stok, adjustment, mutasi)
- [ ] Purchase Order full flow (Purchasing buat → Admin approve → Warehouse terima → stok update)
- [ ] Sales Order full flow (Admin buat → Warehouse approve → stok update)
- [ ] Stock Alert (notifikasi stok minimum)
- [ ] Stock Opname

### Sprint 3 — Finance, Report & Polish (Week 5-6)

- [ ] Transaction / Pembayaran (Finance)
- [ ] Laporan Penjualan (per hari/bulan)
- [ ] Laporan Pembelian (per PO)
- [ ] Laporan Profit
- [ ] Dashboard + Chart.js (grafik penjualan & pembelian)
- [ ] Export PDF (DomPDF)
- [ ] Testing & Bug Fix
- [ ] Final Review & Deploy

---

## 8. Tech Stack Detail

| Layer | Technology |
|-------|------------|
| **Backend** | Laravel 11 (PHP 8.2+) |
| **Frontend** | Blade + TailwindCSS 3 |
| **Database** | MySQL 8.0 |
| **Auth** | Laravel Breeze |
| **Chart** | Chart.js 4 |
| **PDF Export** | barryvdh/laravel-dompdf |
| **Icons** | Heroicons / Lucide Icons |
| **Build Tool** | Vite |

---

## 9. Struktur Folder Laravel (Rencana)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   ├── Admin/
│   │   │   ├── UserController.php
│   │   │   └── DashboardController.php
│   │   ├── ProductController.php
│   │   ├── CategoryController.php
│   │   ├── SupplierController.php
│   │   ├── StockController.php
│   │   ├── PurchaseOrderController.php
│   │   ├── SalesOrderController.php
│   │   ├── TransactionController.php
│   │   └── ReportController.php
│   ├── Middleware/
│   │   └── RoleMiddleware.php
│   └── Requests/
│       ├── ProductRequest.php
│       ├── PurchaseOrderRequest.php
│       ├── SalesOrderRequest.php
│       └── ...
├── Models/
│   ├── User.php
│   ├── Category.php
│   ├── Product.php
│   ├── Supplier.php
│   ├── Stock.php
│   ├── StockMutation.php
│   ├── PurchaseOrder.php
│   ├── PurchaseOrderItem.php
│   ├── SalesOrder.php
│   ├── SalesOrderItem.php
│   └── Transaction.php
├── Services/
│   ├── StockService.php
│   ├── PurchaseOrderService.php
│   └── SalesOrderService.php
resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php
│   ├── auth/
│   ├── dashboard/
│   ├── users/
│   ├── products/
│   ├── categories/
│   ├── suppliers/
│   ├── stocks/
│   ├── purchase-orders/
│   ├── sales-orders/
│   ├── transactions/
│   └── reports/
database/
├── migrations/
├── seeders/
│   ├── RoleSeeder.php
│   └── UserSeeder.php
```

---

## 10. Referensi

- Skripsi: **Skripsi Rendy** (dokumen requirements asli)
- Framework: [Laravel 11 Documentation](https://laravel.com/docs/11.x)
- UI: [TailwindCSS](https://tailwindcss.com/)

---

> **Dibuat oleh:** enowX Labs AI Assistant
> **Tanggal:** 2025
> **Status:** Draft — Siap untuk development
