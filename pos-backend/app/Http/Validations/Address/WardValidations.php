<?php
namespace App\Http\Validations\Address;

use Validator;

class WardValidations
{
    /**
     * Upazila Validation
     */
    public static function validate($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'division_id'  => 'required|integer|exists:divisions,id',
            'district_id'  => 'required|integer|exists:districts,id',
            'upazila_id'  => 'required|integer|exists:upazillas,id',
            'union_id'  =>  'required|integer|exists:unions,id',
        ]);

        if ($validator->fails()) {
            return ([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        return ['success'=>true];
    }

}
