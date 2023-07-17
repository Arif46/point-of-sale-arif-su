<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paurashava extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "paurashavas";

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Self::getPaurashavaCode();
        });
    }

    public static function getPaurashavaCode()
    {
        $paurashavaCode = 7777;

        $model = Self::latest()->first(['id', 'code']);

        if ($model) {
            $paurashavaCode = (int) $model->code + 1;
        }

        return $paurashavaCode;
    }
}
