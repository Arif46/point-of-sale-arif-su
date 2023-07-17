<?php
namespace App\Http\Validations\Address;

use Illuminate\Validation\Rule;
use Validator;

class PaurosovaValidations
{
    /**
   * Master Union Validator
   */
    public static function validate($request, $id = 0)
    {
        $name = $request->name;
        $upazila_id   = $request->upazila_id;

        $validator = Validator::make($request->all(), [
        'name' => [
            'required',
            Rule::unique('paurashavas')->where(function ($query) use($name, $upazila_id , $id) {
                $subQuery = $query->where('name', $name)
                            ->where('upazila_id', $upazila_id);
                if ($id) {
                    $subQuery = $subQuery->where('id','!=',$id);
                }

                return $subQuery;
            }),
        ],
        'division_id'    => 'required',
        'district_id'    => 'required',
        'upazila_id'     =>'required'
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }
        return ['success' => true];
    }

}
