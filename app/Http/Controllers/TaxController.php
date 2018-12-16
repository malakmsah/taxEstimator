<?php
/**
 * Created by PhpStorm.
 * User: malak
 * Date: 12/15/18
 * Time: 9:31 PM
 */

namespace App\Http\Controllers;

use App\Helpers\TaxCalculationsHelper;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

/**
 * Class TaxController
 * @package App\Http\Controllers
 */
class TaxController extends Controller
{
    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'income' => ['required', 'numeric'],
            'spouse_income' => ['required', 'numeric'],
            'marital_status' => ['required', 'in:true,false'],
            'resident' => ['required', 'in:true,false'],
            'spouse_resident' => ['required', 'in:true,false'],
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function estimate()
    {
        $data = Input::get();

        $validator = $this->validator($data);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'data' => $validator->errors()
                ],
                '400'
            );
        }

        $result = TaxCalculationsHelper::calculateForTaxPayer(
            $data['income'],
            $data['resident'],
            $data['marital_status'],
            $data['spouse_income'],
            $data['spouse_resident']
        );
        return response()->json([
            'status' => 'success',
            'data' => $result
        ]);
    }
}
