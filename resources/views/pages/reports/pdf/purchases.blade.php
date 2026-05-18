<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Report - PT Mesama Global Indonesia</title>
    <style>
        @page { margin: 1.5cm 1cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10px; line-height: 1.5; color: #000; margin: 0; padding: 0; }
        
        /* Formal Corporate Header */
        .header-table { width: 100%; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 2px; }
        .company-name { font-size: 18px; font-weight: bold; margin: 0; color: #000; }
        .company-info { font-size: 9px; color: #333; margin-top: 5px; line-height: 1.3; }
        .report-title-cell { text-align: right; vertical-align: bottom; }
        .report-title-main { font-size: 16px; font-weight: bold; text-transform: uppercase; margin: 0; }
        
        .header-divider { border-bottom: 0.5px solid #000; margin-bottom: 25px; }

        /* Report Metadata */
        .meta-table { width: 100%; margin-bottom: 20px; }
        .meta-label { font-weight: bold; width: 100px; }
        .meta-value { color: #333; }

        /* Summary Section (Formal) */
        .summary-table { width: 100%; margin-bottom: 25px; border: 1px solid #ccc; background: #f9f9f9; }
        .summary-cell { padding: 12px; border-right: 1px solid #ccc; text-align: center; }
        .summary-cell:last-child { border-right: none; }
        .summary-label { font-size: 8px; font-weight: bold; text-transform: uppercase; color: #555; margin-bottom: 5px; display: block; }
        .summary-value { font-size: 12px; font-weight: bold; color: #000; }

        /* Data Table (Formal Standards) */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th { background-color: #eee; color: #000; text-transform: uppercase; font-size: 9px; font-weight: bold; padding: 10px 8px; text-align: left; border: 1px solid #ccc; }
        .data-table td { padding: 8px; border: 1px solid #ccc; vertical-align: top; }
        .data-table tr:nth-child(even) { background-color: #fafafa; }
        
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        /* Footer */
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 8px; color: #777; border-top: 1px solid #ccc; padding-top: 5px; }
        .pagenum:before { content: counter(page); }
    </style>
</head>
<body>
    <!-- Header -->
    <table class="header-table">
        <tr>
            <td width="60%">
                <div class="company-name">PT Mesama Global Indonesia</div>
                <div class="company-info">
                    Sudirman Central Business District (SCBD), No. 123, Jakarta Selatan<br>
                    Telp: (021) 555-0192 | Email: billing@mesamaglobal.com
                </div>
            </td>
            <td width="40%" class="report-title-cell">
                <h1 class="report-title-main">Laporan Pembelian</h1>
            </td>
        </tr>
    </table>
    <div class="header-divider"></div>

    <!-- Metadata -->
    <table class="meta-table">
        <tr>
            <td class="meta-label">Periode Laporan</td>
            <td class="meta-value">: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="meta-label">Tanggal Cetak</td>
            <td class="meta-value">: {{ now()->format('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <!-- Summary -->
    <table class="summary-table">
        <tr>
            <td class="summary-cell">
                <span class="summary-label">Total Transaksi</span>
                <span class="summary-value">{{ $summary['total_orders'] }} Transaksi</span>
            </td>
            <td class="summary-cell">
                <span class="summary-label">Total Pengeluaran (PO)</span>
                <span class="summary-value">Rp {{ number_format($summary['total_expense'], 0, ',', '.') }}</span>
            </td>
        </tr>
    </table>

    <!-- Data -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="30">No.</th>
                <th width="80">Tanggal</th>
                <th>No. Purchase Order</th>
                <th>Nama Supplier</th>
                <th class="text-right">Total Belanja (IDR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseOrders as $index => $po)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $po->po_date->format('d/m/Y') }}</td>
                <td class="font-bold">{{ $po->po_number }}</td>
                <td style="text-transform: uppercase;">{{ $po->supplier->name }}</td>
                <td class="text-right font-bold">{{ number_format($po->total_amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #eee;">
                <td colspan="4" class="text-right font-bold" style="padding: 10px; text-transform: uppercase;">Total Akumulasi Pembelian</td>
                <td class="text-right font-bold" style="padding: 10px; font-size: 11px;">Rp {{ number_format($summary['total_expense'], 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak secara otomatis oleh StockSell ERP - Halaman <span class="pagenum"></span>
    </div>
</body>
</html>
