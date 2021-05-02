<?php


namespace App\Utils\MatrixCalculator;


abstract class  MatrixCalculator
{
    protected $matrixA;
    protected $matrixB;
    protected $result;


    public function __construct(array $matrixA, array $matrixB)
    {
        $this->matrixA = new Matrix($matrixA);
        $this->matrixB = new Matrix($matrixB);
        $this->result = [];
    }

    public function getResult(): array
    {
        return $this->result;
    }

    public function toExcel() : array
    {
        return (new MatrixToExcel())->toExelCol($this->result);
    }

    abstract function calculate(): MatrixCalculator;
}
