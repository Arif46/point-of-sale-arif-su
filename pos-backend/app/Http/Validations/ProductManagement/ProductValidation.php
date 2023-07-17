<?php
namespace App\Http\Validations\ProductManagement;

use Validator;

class ProductValidation
{
    /**
     * Brand Validation
     */
    public static function validate($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'shop_id' =>'required|exists:shops,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'unit_id' => 'required|exists:units,id',
            'size_id' => 'required|exists:sizes,id',
            'color_id' => 'required|exists:colors,id'
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
