<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityCorporation extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "city_corporations";

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Self::getCityCorporationCode();
        });
    }

    public static function getCityCorporationCode()
    {
        $Code =7070;

        $model = Self::latest()->first(['id', 'code']);

        if ($model) {
            $Code = (int) $model->code + 1;
        }

        return $Code;
    }
}
