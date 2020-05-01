<?php
namespace App\models;

trait TCalcRows
{
    public function calc(array $rows): int
    {
        return count($rows);
    }
}