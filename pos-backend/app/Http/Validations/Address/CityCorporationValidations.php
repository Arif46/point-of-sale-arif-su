<?php
namespace App\Http\Validations\Address;

use Validator;

class CityCorporationValidations
{
    /**
     * Division Validation
     */
    public static function validate($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|unique:city_corporations,name,'.$id,
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
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
