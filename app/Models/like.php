<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    use HasFactory;

    public $table = 'likes';

    public $primaryKey = 'id';

    public $fillable=[
        'product_id',
        'owner_id'
    ];

    public $timestamps = true;

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'owner_id');
    }
}
