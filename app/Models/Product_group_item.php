<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_group_item extends Model
{
    use HasFactory;

    protected $primaryKey = 'item_id';

    public function group()
    {
        return $this->belongsTo(User_product_group::class);
    }
}
