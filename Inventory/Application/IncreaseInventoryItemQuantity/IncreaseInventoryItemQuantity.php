<?php


namespace App\Inventory\Application\IncreaseInventoryItemQuantity;

use App\Inventory\Domain\Exceptions\InventoryItemRepositoryOperationException;
use App\Inventory\Domain\Repositories\InventoryItemRepositoryInterface;

class IncreaseInventoryItemQuantity implements IncreaseInventoryItemQuantityInterface
{
    private InventoryItemRepositoryInterface $inventoryItemRepository;

    /**
     * IncreaseInventoryItemQuantity constructor.
     * @param InventoryItemRepositoryInterface $inventoryItemRepository
     */
    public function __construct(InventoryItemRepositoryInterface $inventoryItemRepository)
    {
        $this->inventoryItemRepository = $inventoryItemRepository;
    }

    /**
     * @inheritDoc
     * @throws InventoryItemRepositoryOperationException
     */
    public function execute(IncreaseInventoryItemQuantityInput $input): IncreaseInventoryItemQuantityResult
    {
        $productCode = $input->inventoryItem()["product_code"];
        $quantity = $input->inventoryItem()["quantity"];
        $inventoryItem = $this->inventoryItemRepository->findOneByProductCode($productCode);

        if (! $inventoryItem)
        {
            throw new InventoryItemRepositoryOperationException("Inventory item with product code " . $productCode . " not found");
        }

        $inventoryItem->increaseStock($quantity);
        $this->inventoryItemRepository->update($inventoryItem);
        return new IncreaseInventoryItemQuantityResult($inventoryItem);
    }
}
