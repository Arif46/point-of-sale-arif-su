<?php
namespace App\Http\Validations\UserManagement;

use Validator;

class RoleValidations
{
    /**
     * Shop Validation
    */
    public static function validate($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'shop_id' => 'required|integer',
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
