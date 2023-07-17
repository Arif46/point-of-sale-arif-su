<?php
namespace App\Http\Validations\Address;

use Validator;

class UpazilaValidations
{
    /**
     * Upazila Validation
     */
    public static function validate($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|unique:upazillas,name,'.$id,
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
