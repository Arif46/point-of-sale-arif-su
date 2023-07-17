<?php

namespace App\Models\ProductManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "units";

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
