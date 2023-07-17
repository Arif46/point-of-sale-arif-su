<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "districts";

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
            $model->code = Self::getDistrictCode();
        });
    }

    public static function getDistrictCode()
    {
        $districtCode = 5555;

        $model = Self::latest()->first(['id', 'code']);

        if ($model) {
            $districtCode = (int) $model->code + 1;
        }

        return $districtCode;
    }
}
