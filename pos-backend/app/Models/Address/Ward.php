<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
    */

    protected $table = 'wards';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Self::getWardCode();
        });
    }

    public static function getWardCode()
    {
        $wardCode = 9999;

        $model = Self::latest()->first(['id', 'code']);

        if ($model) {
            $wardCode = (int) $model->code + 1;
        }

        return $wardCode;
    }
}
