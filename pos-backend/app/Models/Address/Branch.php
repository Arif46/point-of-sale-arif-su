<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "branches";

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
