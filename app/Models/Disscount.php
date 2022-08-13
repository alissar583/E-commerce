<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disscount extends Model
{
    use HasFactory;
//    public $table = 'disscounts';
//    public $primaryKey = 'id';
    public $timestamps = true;
    public $fillable = [
        'discount_precentage',
        'date',
        'product_id',
    ];
}
