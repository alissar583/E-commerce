<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $table = 'comments';

    public $primaryKey = 'id';

    public $fillable = [
        'value', 'owner_id', 'product_id'
    ];

    public $timestamps = true;

    public function product(){
        return $this->belongsTo(Product::class, 'product_id')
            ->whereDate('expired_date', '>=', now());

    }
    public function user(){
        return $this->belongsTo(User::class, 'owner_id');
    }
}
