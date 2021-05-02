<?php


namespace App\Utils\MatrixCalculator;


class Matrix
{
    private  $values;

    public function __construct(array $values = [])
    {
        $this->values = $values;
    }

    public function getRowsCount(): int
    {
        return count($this->values);
    }

    public function getColumnsCount(): int
    {
        $first = reset($this->values);
        if(!is_array($first)){
            return 0;
        }
        return count($first);
    }

    public function getValues(): array
    {
        return $this->values;
    }
}
