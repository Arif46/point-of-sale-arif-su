<?php
namespace App\Http\Validations\Address;

use Validator;

class DivisionValidations
{
    /**
     * Division Validation
     */
    public static function validate($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|unique:divisions,name,'.$id
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
