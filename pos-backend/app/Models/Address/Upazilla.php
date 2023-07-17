<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upazilla extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */

    protected $table = 'upazillas';

    protected $guarded = ['id', 'created_at', 'updated_at'];

     /**
     * Auto generate code.
     *
     * @var array
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Self::getUpazilaCode();
        });
    }

    public static function getUpazilaCode()
    {
        $upazilaCode = 6666;

        $model = Self::latest()->first(['id', 'code']);

        if ($model) {
            $upazilaCode = (int) $model->code + 1;
        }

        return $upazilaCode;
    }
}
