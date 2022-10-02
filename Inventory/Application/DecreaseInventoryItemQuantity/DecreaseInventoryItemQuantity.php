<?php


namespace App\Inventory\Application\DecreaseInventoryItemQuantity;

use App\Inventory\Domain\Exceptions\InventoryItemRepositoryOperationException;
use App\Inventory\Domain\Repositories\InventoryItemRepositoryInterface;

class DecreaseInventoryItemQuantity implements DecreaseInventoryItemQuantityInterface
{
    private InventoryItemRepositoryInterface $inventoryItemRepository;

    /**
     * DecreaseInventoryItemQuantity constructor.
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
    public function execute(DecreaseInventoryItemQuantityInput $input): DecreaseInventoryItemQuantityResult
    {
        $productCode = $input->inventoryItem()["product_code"];
        $quantity = $input->inventoryItem()["quantity"];
        $inventoryItem = $this->inventoryItemRepository->findOneByProductCode($productCode);

        if (! $inventoryItem)
        {
            throw new InventoryItemRepositoryOperationException("Inventory item with product code " . $productCode . " does not exist");
        }

        $inventoryItem->decreaseStock($quantity);
        $this->inventoryItemRepository->update($inventoryItem);

        return new DecreaseInventoryItemQuantityResult($inventoryItem);
    }
}
