<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'slug',
        'status',
        'created_at'
    ];

    public function geSubcategoryList()
    {
        return DB::table('subcategories')
            ->leftjoin('categories', 'subcategories.category_id', '=', 'categories.id')
            ->select('subcategories.*', 'categories.name as category_name')
            ->paginate(5);
    }
}
