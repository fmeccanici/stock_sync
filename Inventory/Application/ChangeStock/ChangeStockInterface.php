<?php


namespace App\Inventory\Application\ChangeStock;


interface ChangeStockInterface
{
    /**
     * @param ChangeStockInput $input
     * @return ChangeStockResult
     */
    public function execute(ChangeStockInput $input): ChangeStockResult;
}
