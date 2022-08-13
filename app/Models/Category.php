<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $table = 'categories';

    public $primaryKey = 'id';

    public $fillable = [
      'name', 'img_url'
    ];

    public $timestamps = true;



public function products(){
    return $this->hasMany(Product::class, 'category_id');
}
}

