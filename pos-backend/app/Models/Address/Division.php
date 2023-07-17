<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */

     protected $table = 'divisions';

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
            $model->code = Self::getDivisionCode();
        });
    }

    public static function getDivisionCode()
    {
        $divisionCode = 4444;

        $model = Self::latest()->first(['id', 'code']);

        if ($model) {
            $divisionCode = (int) $model->code + 1;
        }

        return $divisionCode;
    }
}
