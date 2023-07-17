<?php

namespace App\Models\ProductManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "categories";

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
            $model->code = Self::getCategoryCode();
        });
    }

    public static function getCategoryCode()
    {
        $categoryCode = 11111;

        $model = Self::latest()->first(['id', 'code']);

        if ($model) {
            $categoryCode = (int) $model->code + 1;
        }

        return $categoryCode;
    }
}
