<?php


namespace App\Inventory\Application\IncreaseInventoryItemQuantity;


interface IncreaseInventoryItemQuantityInterface
{
    /**
     * @param IncreaseInventoryItemQuantityInput $input
     * @return IncreaseInventoryItemQuantityResult
     */
    public function execute(IncreaseInventoryItemQuantityInput $input): IncreaseInventoryItemQuantityResult;
}
