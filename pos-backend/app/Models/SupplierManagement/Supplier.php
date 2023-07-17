<?php

namespace App\Models\SupplierManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "suppliers";

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
