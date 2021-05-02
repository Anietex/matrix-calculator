<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Utils\MatrixCalculator\MatrixMultiplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MatrixCalculator extends Controller
{
    use ApiResponse;

    public function multiply(Request $request): JsonResponse
    {

        $arrayInput = [
            'a' => json_decode($request->input('a','')),
            'b' => json_decode($request->input('b',''))
        ];

        Validator::validate($arrayInput, [
            'a' => ['required','array'],
            'b' => ['required','array']
        ]);

        $matrixMultiplication = new MatrixMultiplication($arrayInput['a'], $arrayInput['b']);

        try {
            $result = $matrixMultiplication->calculate()->toExcel();
            return  $this->success($result);
        }catch (\Exception $exception){
            return  $this->error($exception->getMessage(), 500);
        } catch (\Throwable $e) {
            return  $this->error($e->getMessage(), 400);
        }


    }
}
