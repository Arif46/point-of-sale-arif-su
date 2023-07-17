<?php
namespace App\Http\Validations\Address;

use Validator;

class BranchValidation
{
    /**
     * Upazila Validation
     */
    public static function validate($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|unique:branches,name,'.$id,
            'bank_id' => 'required|exists:banks,id',
            'address' => 'required|string',
            'telephone' => 'required|integer',
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
