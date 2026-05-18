<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class SalesOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'so_number',
        'customer_name',
        'customer_phone',
        'so_date',
        'total_amount',
        'status',
        'payment_status',
        'shipping_address',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'so_date' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class, 'reference', 'so_number');
    }

    public function isStockConfirmed()
    {
        return $this->stockMovements()->exists();
    }

    public static function generateSoNumber()
    {
        $prefix = 'SO';
        $date = date('Ymd');
        
        $lastSo = self::whereDate('created_at', date('Y-m-d'))
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastSo) {
            $number = '001';
        } else {
            $lastNumber = (int) substr($lastSo->so_number, -3);
            $number = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        return "{$prefix}/{$date}/{$number}";
    }

    public function calculateTotal()
    {
        return $this->items()->sum('subtotal');
    }
}
