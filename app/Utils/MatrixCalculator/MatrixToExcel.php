<?php


namespace App\Utils\MatrixCalculator;

class MatrixToExcel
{

    public function toExelCol(array $matrix): array
    {
        $newMatrix = [];
        foreach ($matrix as $key =>$row){
            $newMatrix[$key] = $this->mapIndexToExcelCol($row);
        }
        return $newMatrix;
    }

    private function mapIndexToExcelCol($row): array
    {
        $totalCol = count($row);
        $start = 'A';
        $chars = [];
        for($i = 0; $i< $totalCol; $i++){
            $chars[] = $start++;
        }
        return array_combine($chars,$row);
    }

}
