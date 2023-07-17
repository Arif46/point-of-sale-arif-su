<?php

namespace App\Models\ProductManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "colors";

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Self::getColorCode();
        });
    }

    public static function getColorCode()
    {
        $colorCode = 3333;

        $model = Self::latest()->first(['id', 'code']);

        if ($model) {
            $colorCode = (int) $model->code + 1;
        }

        return $colorCode;
    }
}
