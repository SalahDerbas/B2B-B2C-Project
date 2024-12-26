<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemSource extends Model
{
    use HasFactory , SoftDeletes;
    protected $table   = "item_sources";
    protected $guarded = ['id'];

    public static function getTableName() {
        return with(new static)->getTable();
    }

    public function getPaymentPrice()
    {
        return $this->hasMany(PaymentPrice::class, 'item_source_id', 'id');
    }

}
