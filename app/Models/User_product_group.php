<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_product_group extends Model
{
    use HasFactory;

    protected $primaryKey = 'group_id';

    public function items()
    {
        return $this->hasMany(Product_group_item::class,'group_id');
    }
}
