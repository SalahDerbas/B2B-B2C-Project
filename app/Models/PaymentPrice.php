<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentPrice extends Model
{
    use HasFactory , SoftDeletes;
    protected $table   = "payment_prices";
    protected $guarded = ['id'];

    public static function getTableName() {
        return with(new static)->getTable();
    }
    public function getItemSource()
    {
        return $this->hasOne(ItemSource::class, 'id', 'item_source_id');
    }

    public function getPayment()
    {
        return $this->hasOne(Payment::class, 'id', 'payment_id');
    }
}
