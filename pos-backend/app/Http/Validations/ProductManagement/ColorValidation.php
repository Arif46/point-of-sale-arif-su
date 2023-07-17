<?php
namespace App\Http\Validations\ProductManagement;

use Validator;

class ColorValidation
{
    /**
     * Category Validation
     */
    public static function validate($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'shop_id' => 'required|exists:shops,id',
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
