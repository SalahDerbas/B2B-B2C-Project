<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory , SoftDeletes;
    protected $table   = "admins";
    protected $guarded = ['id'];

    public static function getTableName() {
        return with(new static)->getTable();
    }

}
