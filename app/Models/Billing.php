<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Billing extends Model
{
    use HasFactory , SoftDeletes;
    protected $table   = "billings";
    protected $guarded = ['id'];

    public static function getTableName() {
        return with(new static)->getTable();
    }

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getPayment()
    {
        return $this->hasOne(Payment::class, 'id', 'payment_id');
    }

    public function getStatus()
    {
        return $this->hasOne(Lookup::class, 'id', 'status_id');
    }
}
