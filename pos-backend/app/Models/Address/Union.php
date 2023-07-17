<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "unions";

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Self::getUnionCode();
        });
    }

    public static function getUnionCode()
    {
        $unionCode = 8888;

        $model = Self::latest()->first(['id', 'code']);

        if ($model) {
            $unionCode = (int) $model->code + 1;
        }

        return $unionCode;
    }
}
