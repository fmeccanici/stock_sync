<?php


namespace App\Inventory\Application\IncreaseInventoryItemQuantity;


use App\Inventory\Domain\InventoryItems\InventoryItem;

final class IncreaseInventoryItemQuantityResult
{
    /**
     * @var InventoryItem
     */
    private InventoryItem $inventoryItem;

    public function __construct(InventoryItem $inventoryItem)
    {
        $this->inventoryItem = $inventoryItem;
    }

    public function inventoryItem(): InventoryItem
    {
        return $this->inventoryItem;
    }
}
