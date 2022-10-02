<?php


namespace App\Inventory\Application\DecreaseInventoryItemQuantity;


interface DecreaseInventoryItemQuantityInterface
{
    /**
     * @param DecreaseInventoryItemQuantityInput $input
     * @return DecreaseInventoryItemQuantityResult
     */
    public function execute(DecreaseInventoryItemQuantityInput $input): DecreaseInventoryItemQuantityResult;
}
