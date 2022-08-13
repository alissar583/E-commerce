<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $table = 'products';

    public $primaryKey = 'id';

    public $fillable = [
        'name', 'price', 'image_url', 'expired_date', 'quantity', 'owner_id', 'category_id',
        'count_views'
    ];

    public $withCount = ['comments', 'likes'];

    public $timestamps = true;


    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function comments(){
        return $this->hasMany(Comment::class, 'product_id');
    }
    public function likes(){
        return $this->hasMany(like::class, 'product_id');
    } public function disscounts(){
        return $this->hasMany(Disscount::class, 'product_id')->orderBy('date');
    }



//    public function discount(){
//        return $this->hasOne(Discount::class, 'product_id');
//    }

}
