<?php

namespace App\Models\ProductManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "sizes";

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Self::getSizeCode();
        });
    }

    public static function getSizeCode()
    {
        $sizeCode = 7070;

        $model = Self::latest()->first(['id', 'code']);

        if ($model) {
            $sizeCode = (int) $model->code + 1;
        }

        return $sizeCode;
    }
}
