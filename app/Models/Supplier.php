<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
        'city',
        'npwp',
        'status',
        'notes',
    ];

    /**
     * Relasi ke Purchase Orders (akan digunakan di Fase berikutnya)
     */
    public function purchaseOrders()
    {
        return $this->hasMany(\App\Models\PurchaseOrder::class);
    }

    /**
     * Generate kode supplier otomatis: SUP-001, SUP-002, dst.
     */
    public static function generateCode(): string
    {
        $lastSupplier = self::orderBy('id', 'desc')->first();
        $nextNumber = $lastSupplier ? ((int) substr($lastSupplier->code, 4)) + 1 : 1;
        return 'SUP-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Scope untuk supplier aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk supplier tidak aktif
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
