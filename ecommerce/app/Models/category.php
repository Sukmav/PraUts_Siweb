<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\product;

class category extends Model
{
    protected $table ='categories';
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'category_id',
        'category_name',
    ];

    public function products()
    {
        return $this->belongsToMany(product::class, 'category_id', 'category_id');
    }
}
