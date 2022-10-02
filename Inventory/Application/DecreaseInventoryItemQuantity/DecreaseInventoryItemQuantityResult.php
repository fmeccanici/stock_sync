<?php


namespace App\Inventory\Application\DecreaseInventoryItemQuantity;


use App\Inventory\Domain\InventoryItems\InventoryItem;

final class DecreaseInventoryItemQuantityResult
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
