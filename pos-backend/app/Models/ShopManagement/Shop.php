<?php

namespace App\Models\ShopManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "shops";

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
