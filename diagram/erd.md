# Entity Relationship Diagram (ERD) - StockSell ERP

Diagram ini menunjukkan hubungan antar entitas utama dalam sistem StockSell ERP.

![Complete ERD PNG](erd_complete.png)

```mermaid
erDiagram
    USER ||--o{ PURCHASE_ORDER : "creates"
    USER ||--o{ SALES_ORDER : "creates"
    USER ||--o{ TRANSACTION : "records"
    USER ||--o{ STOCK_ADJUSTMENT : "performs"
    USER ||--o{ STOCK_MOVEMENT : "logs"

    SUPPLIER ||--o{ PURCHASE_ORDER : "supplies"

    CATEGORY ||--o{ PRODUCT : "contains"

    PRODUCT ||--o{ PURCHASE_ORDER_ITEM : "included_in"
    PRODUCT ||--o{ SALES_ORDER_ITEM : "included_in"
    PRODUCT ||--o{ STOCK_ADJUSTMENT : "adjusted"
    PRODUCT ||--o{ STOCK_MOVEMENT : "moved"

    PURCHASE_ORDER ||--|{ PURCHASE_ORDER_ITEM : "has"
    PURCHASE_ORDER ||--o{ TRANSACTION : "has_payments"

    SALES_ORDER ||--|{ SALES_ORDER_ITEM : "has"
    SALES_ORDER ||--o{ TRANSACTION : "has_payments"

    USER {
        bigint id PK
        string name
        string email
        string password
        string role "admin, finance, warehouse, purchasing"
    }

    SUPPLIER {
        bigint id PK
        string code
        string name
        string contact_person
        string phone
        string email
    }

    CATEGORY {
        bigint id PK
        string name
        string slug
    }

    PRODUCT {
        bigint id PK
        bigint category_id FK
        string sku
        string name
        decimal purchase_price
        decimal selling_price
        integer stock
        integer min_stock
    }

    PURCHASE_ORDER {
        bigint id PK
        bigint supplier_id FK
        bigint created_by FK
        string po_number
        date po_date
        decimal total_amount
        string status "draft, pending, received, cancelled"
        string payment_status "unpaid, partial, paid"
    }

    PURCHASE_ORDER_ITEM {
        bigint id PK
        bigint purchase_order_id FK
        bigint product_id FK
        integer quantity
        decimal unit_price
        decimal subtotal
    }

    SALES_ORDER {
        bigint id PK
        bigint created_by FK
        string so_number
        string customer_name
        date so_date
        decimal total_amount
        string status "draft, processing, completed, cancelled"
        string payment_status "unpaid, partial, paid"
    }

    SALES_ORDER_ITEM {
        bigint id PK
        bigint sales_order_id FK
        bigint product_id FK
        integer quantity
        decimal unit_price
        decimal subtotal
    }

    TRANSACTION {
        bigint id PK
        bigint sales_order_id FK
        bigint purchase_order_id FK
        bigint created_by FK
        string type "income, expense"
        decimal amount
        string payment_method
        date payment_date
    }

    STOCK_ADJUSTMENT {
        bigint id PK
        bigint product_id FK
        bigint created_by FK
        string adjustment_number
        integer quantity
        string type "in, out"
        string reason
    }

    STOCK_MOVEMENT {
        bigint id PK
        bigint product_id FK
        bigint user_id FK
        string type "in, out"
        integer quantity
        string reference
        string reason
    }
```

---

## Penjelasan Relasi Utama:

1.  **Pengadaan (Purchasing)**:
    - `Purchasing` membuat `PurchaseOrder` yang terhubung ke satu `Supplier`.
    - `PurchaseOrder` berisi banyak `PurchaseOrderItem` (produk yang dibeli).
    - Finance melunasi pembayaran (`Transaction` - Expense) terlebih dahulu, kemudian Warehouse mengonfirmasi penerimaan fisik barang (`StockMovement` - Inbound) yang mengubah status PO menjadi `received`.

2.  **Penjualan (Sales)**:
    - `Admin` membuat `SalesOrder` untuk pelanggan.
    - `SalesOrder` berisi banyak `SalesOrderItem` (produk yang dijual).
    - Finance menerima pelunasan pembayaran (`Transaction` - Income) terlebih dahulu, kemudian Warehouse mengemas dan mengirimkan barang fisik (`StockMovement` - Outbound) yang mengubah status SO menjadi `completed`.

3.  **Manajemen Stok (Inventory)**:
    - Setiap perubahan stok baik dari PO, SO, maupun manual recorded di `StockMovement`.
    - `StockAdjustment` digunakan untuk koreksi stok manual (misal: barang rusak atau selisih opname).
