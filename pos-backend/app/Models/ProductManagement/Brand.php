<?php

namespace App\Models\ProductManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "brands";

    protected $guarded = ['id', 'created_at', 'updated_at'];
    /**
     * generate code
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Self::getBrandCode();
        });
    }

    public static function getBrandCode()
    {
        $brandCode = 2222;

        $model = Self::latest()->first(['id', 'code']);

        if ($model) {
            $brandCode = (int) $model->code + 1;
        }

        return $brandCode;
    }
}
