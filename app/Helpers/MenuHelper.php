<?php

namespace App\Helpers;

class MenuHelper
{
    public static function getMainNavItems()
    {
        $role = auth()->check() ? auth()->user()->role : 'admin';
        $salesName = 'Pesanan Penjualan (SO)';
        if ($role === 'warehouse') {
            $salesName = 'Validasi Pengiriman';
        } elseif ($role === 'finance') {
            $salesName = 'Tagihan & Faktur';
        }

        $poBadge = \App\Models\PurchaseOrder::where('status', 'pending')->count();
        $soBadge = \App\Models\SalesOrder::where('status', 'processing')->count();

        $poBadge = $poBadge > 0 ? $poBadge : null;
        $soBadge = $soBadge > 0 ? $soBadge : null;

        return [
            [
                'icon' => 'insights',
                'name' => 'Dashboard',
                'path' => '/dashboard',
                'roles' => ['admin', 'finance', 'warehouse', 'purchasing'],
            ],
            [
                'name' => 'Master Data',
                'icon' => 'inventory',
                'roles' => ['admin', 'warehouse'],
                'subItems' => [
                    ['name' => 'Data Produk', 'path' => '/products', 'icon' => 'cube', 'roles' => ['admin', 'warehouse']],
                    ['name' => 'Kategori Produk', 'path' => '/categories', 'icon' => 'layers', 'roles' => ['admin', 'warehouse']]
                ],
            ],
            [
                'name' => 'Pembelian',
                'icon' => 'procurement',
                'roles' => ['admin', 'purchasing', 'warehouse', 'finance'],
                'subItems' => [
                    ['name' => 'Pesanan Pembelian (PO)', 'path' => '/purchase-orders', 'icon' => 'file-text', 'roles' => ['admin', 'purchasing', 'warehouse', 'finance'], 'badge' => $poBadge],
                    ['name' => 'Daftar Pemasok', 'path' => '/suppliers', 'icon' => 'users', 'roles' => ['admin', 'purchasing']],
                ],
            ],
            [
                'name' => $salesName,
                'icon' => 'sales',
                'path' => '/sales-orders',
                'roles' => ['admin', 'finance', 'warehouse'],
                'badge' => $soBadge,
            ],
            [
                'name' => 'Kendali Logistik',
                'icon' => 'logistics',
                'roles' => ['admin', 'warehouse'],
                'subItems' => [
                    ['name' => 'Log Pergerakan Stok', 'path' => '/stock-movements', 'icon' => 'activity', 'roles' => ['admin', 'warehouse']],
                ],
            ],
        ];
    }

    public static function getOthersItems()
    {
        return [
            [
                'icon' => 'analytics',
                'name' => 'Laporan & Analitik',
                'roles' => ['admin', 'finance', 'purchasing'],
                'subItems' => [
                    ['name' => 'Buku Transaksi', 'path' => '/transactions', 'icon' => 'ledger', 'roles' => ['admin', 'finance']],
                    ['name' => 'Laporan Pendapatan', 'path' => '/reports/sales', 'icon' => 'trending-up', 'roles' => ['admin', 'finance']],
                    ['name' => 'Laporan Pengeluaran', 'path' => '/reports/purchases', 'icon' => 'trending-down', 'roles' => ['admin', 'finance', 'purchasing']],
                    ['name' => 'Laporan Inventaris', 'path' => '/reports/inventory', 'icon' => 'pie-chart', 'roles' => ['admin', 'finance', 'warehouse']],
                ],
            ],
            [
                'icon' => 'administration',
                'name' => 'Administrasi Sistem',
                'roles' => ['admin', 'finance', 'warehouse', 'purchasing'],
                'subItems' => [
                    ['name' => 'Kelola Pengguna', 'path' => '/users', 'icon' => 'shield', 'roles' => ['admin']],
                    ['name' => 'Pengaturan Profil', 'path' => '/profile', 'icon' => 'user-settings', 'roles' => ['admin', 'finance', 'warehouse', 'purchasing']],
                ],
            ],
        ];
    }

    public static function getMenuGroups()
    {
        $role = auth()->check() ? auth()->user()->role : 'admin';

        // Flattened Menu for Admin
        if ($role === 'admin') {
            return [
                [
                    'title' => 'Menu Administrator',
                    'items' => [
                        ['icon' => 'insights', 'name' => 'Dashboard', 'path' => '/dashboard'],
                        ['icon' => 'cube', 'name' => 'Data Produk', 'path' => '/products'],
                        ['icon' => 'layers', 'name' => 'Kategori Produk', 'path' => '/categories'],
                        ['icon' => 'sales', 'name' => 'Sales Orders (SO)', 'path' => '/sales-orders'],
                        ['icon' => 'activity', 'name' => 'Log Pergerakan Stok', 'path' => '/stock-movements'],
                        ['icon' => 'shield', 'name' => 'Kelola Pengguna', 'path' => '/users'],
                        ['icon' => 'user-settings', 'name' => 'Profil Saya', 'path' => '/profile'],
                    ]
                ]
            ];
        }

        // Flattened Menu for Purchasing
        if ($role === 'purchasing') {
            $poBadge = \App\Models\PurchaseOrder::where('status', 'pending')->count();
            $poBadge = $poBadge > 0 ? $poBadge : null;

            return [
                [
                    'title' => 'Menu Purchasing',
                    'items' => [
                        ['icon' => 'insights', 'name' => 'Dashboard', 'path' => '/dashboard'],
                        ['icon' => 'procurement', 'name' => 'Purchase Orders (PO)', 'path' => '/purchase-orders', 'badge' => $poBadge],
                        ['icon' => 'users', 'name' => 'Data Pemasok', 'path' => '/suppliers'],
                        ['icon' => 'trending-down', 'name' => 'Laporan Belanja', 'path' => '/reports/purchases'],
                        ['icon' => 'user-settings', 'name' => 'Profil Saya', 'path' => '/profile'],
                    ]
                ]
            ];
        }

        // Flattened Menu for Finance
        if ($role === 'finance') {
            $poBadge = \App\Models\PurchaseOrder::where('status', 'pending')->where('payment_status', '!=', 'paid')->count();
            $soBadge = \App\Models\SalesOrder::where('status', 'processing')->where('payment_status', '!=', 'paid')->count();
            
            return [
                [
                    'title' => 'Menu Keuangan',
                    'items' => [
                        ['icon' => 'insights', 'name' => 'Dashboard', 'path' => '/dashboard'],
                        ['icon' => 'sales', 'name' => 'Pembayaran Pelanggan (SO)', 'path' => '/sales-orders', 'badge' => $soBadge > 0 ? $soBadge : null],
                        ['icon' => 'procurement', 'name' => 'Pembayaran Supplier (PO)', 'path' => '/purchase-orders', 'badge' => $poBadge > 0 ? $poBadge : null],
                        ['icon' => 'ledger', 'name' => 'Buku Transaksi', 'path' => '/transactions'],
                        ['icon' => 'trending-up', 'name' => 'Laporan Pendapatan', 'path' => '/reports/sales'],
                        ['icon' => 'trending-down', 'name' => 'Laporan Pengeluaran', 'path' => '/reports/purchases'],
                        ['icon' => 'user-settings', 'name' => 'Profil Saya', 'path' => '/profile'],
                    ]
                ]
            ];
        }

        // Flattened Menu for Warehouse
        if ($role === 'warehouse') {
            $poBadge = \App\Models\PurchaseOrder::where('status', 'pending')->where('payment_status', 'paid')->count();
            $soBadge = \App\Models\SalesOrder::where('status', 'processing')->where('payment_status', 'paid')->count();

            return [
                [
                    'title' => 'Menu Logistik',
                    'items' => [
                        ['icon' => 'insights', 'name' => 'Dashboard', 'path' => '/dashboard'],
                        ['icon' => 'sales', 'name' => 'Pengiriman Barang (SO)', 'path' => '/sales-orders', 'badge' => $soBadge > 0 ? $soBadge : null],
                        ['icon' => 'procurement', 'name' => 'Penerimaan Barang (PO)', 'path' => '/purchase-orders', 'badge' => $poBadge > 0 ? $poBadge : null],
                        ['icon' => 'cube', 'name' => 'Data Produk', 'path' => '/products'],
                        ['icon' => 'layers', 'name' => 'Kategori Produk', 'path' => '/categories'],
                        ['icon' => 'activity', 'name' => 'Log Pergerakan Stok', 'path' => '/stock-movements'],
                        ['icon' => 'user-settings', 'name' => 'Profil Saya', 'path' => '/profile'],
                    ]
                ]
            ];
        }

        $groups = [
            [
                'title' => 'Operasi Utama',
                'items' => self::getMainNavItems()
            ],
            [
                'title' => 'Manajemen & Dukungan',
                'items' => self::getOthersItems()
            ]
        ];

        return self::filterMenuByRole($groups, $role);
    }

    private static function filterMenuByRole($groups, $role)
    {
        $filteredGroups = [];
        foreach ($groups as $group) {
            $filteredItems = [];
            foreach ($group['items'] as $item) {
                if (!isset($item['roles']) || in_array($role, $item['roles'])) {
                    if (isset($item['subItems'])) {
                        $filteredSubItems = [];
                        foreach ($item['subItems'] as $subItem) {
                            if (!isset($subItem['roles']) || in_array($role, $subItem['roles'])) {
                                $filteredSubItems[] = $subItem;
                            }
                        }
                        
                        if (count($filteredSubItems) === 1) {
                            // Extract single submenu item to main level
                            $singleItem = $filteredSubItems[0];
                            
                            // Custom Role Specific Renaming
                            $customName = $singleItem['name'];
                            if ($role === 'warehouse' && $customName === 'Pesanan Pembelian (PO)') {
                                $customName = 'Penerimaan Barang (PO)';
                            }

                            $newItem = [
                                'name' => $customName,
                                'path' => $singleItem['path'],
                                'icon' => $item['icon'], // Use parent's main icon for better visibility
                                'roles' => $item['roles'] ?? [],
                                'badge' => $singleItem['badge'] ?? null
                            ];
                            $filteredItems[] = $newItem;
                        } elseif (count($filteredSubItems) > 1) {
                            $totalBadge = 0;
                            foreach ($filteredSubItems as $si) {
                                if (isset($si['badge'])) $totalBadge += $si['badge'];
                            }
                            if ($totalBadge > 0) $item['badge'] = $totalBadge;
                            
                            $item['subItems'] = $filteredSubItems;
                            $filteredItems[] = $item;
                        }
                    } else {
                        $filteredItems[] = $item;
                    }
                }
            }
            if (count($filteredItems) > 0) {
                $group['items'] = $filteredItems;
                $filteredGroups[] = $group;
            }
        }
        return $filteredGroups;
    }

    public static function isActive($path)
    {
        return request()->is(ltrim($path, '/'));
    }

    public static function getIconSvg($iconName)
    {
        $icons = [
            'insights' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>',
            'inventory' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>',
            'procurement' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
            'sales' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
            'logistics' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-2.235-2.794A1 1 0 0 0 17.06 9.5H15"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>',
            'analytics' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>',
            'administration' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
            
            // Submenu icons (smaller, subtle)
            'cube' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z"/></svg>',
            'layers' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.27a1 1 0 0 0 0 1.83l8.57 4.09a2 2 0 0 0 1.66 0l8.57-4.09a1 1 0 0 0 0-1.83Z"/><path d="m2.6 11.36 8.57 4.1a2 2 0 0 0 1.66 0l8.57-4.1"/><path d="m2.6 15.64 8.57 4.1a2 2 0 0 0 1.66 0l8.57-4.1"/></svg>',
            'file-text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg>',
            'users' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            'activity' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>',
            'settings-alt' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>',
            'ledger' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="18" rx="2"/><line x1="7" y1="8" x2="17" y2="8"/><line x1="7" y1="12" x2="17" y2="12"/><line x1="7" y1="16" x2="17" y2="16"/></svg>',
            'trending-up' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>',
            'trending-down' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>',
            'pie-chart' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>',
            'shield' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
            'user-settings' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="7" r="4"/><path d="M20 21v-2a4 4 0 0 0-3-3.87"/><path d="M4 21v-2a4 4 0 0 1 4-4h5"/><circle cx="19" cy="11" r="2"/></svg>',
        ];

        return $icons[$iconName] ?? '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>';
    }
}
