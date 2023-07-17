<?php
namespace App\Http\Validations\ShopManagment;

use Validator;

class ShopValidation
{
    /**
     * Shop Validation
    */
    public static function validate($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'mobile'  => 'required',
            'owner_name'  => 'required',
            'owner_mobile'  => 'required',
            'area_type_id'  => 'required',
            'division_id'  => 'required',
            'district_id'  => 'required'
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
