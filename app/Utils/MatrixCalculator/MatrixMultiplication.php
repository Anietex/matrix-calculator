<?php


namespace App\Utils\MatrixCalculator;


class MatrixMultiplication extends MatrixCalculator
{

    /**
     * Handles Matrix multiplication
     * @return MatrixCalculator
     *
     * @throws \Throwable
     */
    function calculate(): MatrixCalculator
    {

        $matrixARowCount    =  $this->matrixA->getRowsCount();
        $matrixAColumnCount =  $this->matrixA->getColumnsCount();
        $matrixA     =  $this->matrixA->getValues();

        $matrixBRowCount    =  $this->matrixB->getRowsCount();
        $matrixBColumnCount =  $this->matrixB->getColumnsCount();
        $matrixB      =  $this->matrixB->getValues();

       throw_if($matrixAColumnCount !== $matrixBRowCount, 'Matrix A and B can not be multiplied');
       $result = [];

        for ($i = 0; $i < $matrixARowCount; $i++){
            for($j = 0; $j < $matrixBColumnCount; $j++){
                $result[$i][$j] = 0;
                for($k = 0; $k < $matrixBRowCount; $k++){
                    $result[$i][$j] +=  ($matrixA[$i][$k] ?? 0) * ($matrixB[$k][$j] ?? 0);
                }
            }
        }
        $this->result = $result;

        return  $this;
    }
}
