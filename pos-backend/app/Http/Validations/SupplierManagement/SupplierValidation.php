<?php
namespace App\Http\Validations\SupplierManagement;

use Validator;

class SupplierValidation
{
    /**
     * Brand Validation
     */
    public static function validate($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'code'  => 'required',
            'shop_id' =>'required|exists:shops,id',
            'mobile' =>'required',
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
