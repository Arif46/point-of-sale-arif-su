<?php
namespace App\Http\Validations\Address;

use Illuminate\Validation\Rule;
use Validator;

class DistrictValidations
{
    /**
     * Master District Validation
    */
    public static function validate($request, $id = 0)
    {
        $division_id = $request->division_id;
        $name = $request->name;
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('districts')->where(function ($query) use($name, $division_id ,$id) {
                    $query->where('name', $name)
                                 ->where('division_id', $division_id);
                    if ($id) {
                        $query =$query->where('id', '!=' ,$id);
                    }
                    return $query;
                }),
            ],
            'division_id' => 'required'
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
