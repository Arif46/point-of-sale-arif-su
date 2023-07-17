<?php

namespace App\Models\ProductManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "products";

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Self::getProductCode();
        });
    }

    public static function getProductCode()
    {
        $productCode = 4444;

        $model = Self::latest()->first(['id', 'code']);

        if ($model) {
            $productCode = (int) $model->code + 1;
        }

        return $productCode;
    }
}
