<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "banks";

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
