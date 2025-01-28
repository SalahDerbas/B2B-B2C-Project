<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory , SoftDeletes;
    protected $table   = "categories";
    protected $guarded = ['id'];

    public static function getTableName() {
        return with(new static)->getTable();
    }

    protected $appends = ['has_sub_category'];

    public function getHasSubCategoryAttribute()
    {
        return Category::where('sub_category_id', $this->id)->where('status', 1)->exists();
    }

    public function getCategoryApp()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }
}
