<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory , SoftDeletes;
    protected $table   = "orders";
    protected $guarded = ['id'];

    public static function getTableName() {
        return with(new static)->getTable();
    }

    public function getItemSource()
    {
        return $this->hasOne(ItemSource::class, 'id', 'item_source_id');
    }

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getItem()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function getStatusOrder()
    {
        return $this->hasOne(Lookup::class, 'id', 'status_order');
    }

    public function getStatusPackage()
    {
        return $this->hasOne(Lookup::class, 'id', 'status_package');
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, 'id', 'sub_category_id');
    }

}
