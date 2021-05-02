<?php


namespace App\Utils\MatrixCalculator;


class MatrixMultiplication extends MatrixCalculator
{

    /**
     * @return array
     * @throws \Exception
     */
    function calculate(): array
    {

        $matrixARowCount    =  $this->matrixA->getRowsCount();
        $matrixAColumnCount =  $this->matrixA->getColumnsCount();
        $matrixA     =  $this->matrixA->getValues();


        $matrixBRowCount    =  $this->matrixB->getRowsCount();
        $matrixBColumnCount =  $this->matrixB->getColumnsCount();
        $matrixB      =  $this->matrixB->getValues();



       throw_if($matrixARowCount !== $matrixBColumnCount, 'Matrix A and B can not be multiplied');

       $result = [];

        for ($i = 0; $i < $matrixARowCount; $i++){

            for($j = 0; $j < $matrixBColumnCount; $j++){
                $result[$i][$j] = 0;
                for($k = 0; $k < $matrixBRowCount; $k++){
                    $result[$i][$j] +=  ($matrixA[$i][$k] ?? 0) * ($matrixB[$k][$j] ?? 0);
                }
            }
        }



        return $result;
    }
}
