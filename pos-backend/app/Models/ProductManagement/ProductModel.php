<?php

namespace App\Models\ProductManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "models";

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Self::getModelCode();
        });
    }

    public static function getModelCode()
    {
        $modelCode = 6060;

        $model = Self::latest()->first(['id', 'code']);

        if ($model) {
            $modelCode = (int) $model->code + 1;
        }

        return $modelCode;
    }
}
