<?php

namespace App\Http\Controllers;

use App\Rules\Matrix;
use App\Traits\ApiResponse;
use App\Utils\MatrixCalculator\MatrixMultiplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MatrixCalculatorController extends Controller
{
    use ApiResponse;

    public function multiply(Request $request): JsonResponse
    {

       $data = $request->validate([
           'a' => ['required', new Matrix()],
           'b' => ['required', new Matrix()]
       ]);

       $matrices = [
           'a' => json_decode($data['a']),
           'b' => json_decode($data['b'])
       ];
        try {
            $matrixMultiplication = new MatrixMultiplication($matrices['a'], $matrices['b']);
            $result = $matrixMultiplication->calculate()->toExcel();
            return $this->success($result);
        }catch (\Exception $exception){
            return  $this->error($exception->getMessage(), 400);
        }


    }
}
