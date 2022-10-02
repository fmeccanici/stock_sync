<?php


namespace App\Inventory\Application\ChangeStock;

use App\Inventory\Domain\InventoryItems\InventoryItem;
use App\Inventory\Domain\Repositories\InventoryItemRepositoryInterface;
use Illuminate\Support\Facades\Log;

class ChangeStock implements ChangeStockInterface
{
    protected InventoryItemRepositoryInterface $inventoryItemRepository;

    /**
     * ChangeStock constructor.
     */
    public function __construct(InventoryItemRepositoryInterface $inventoryItemRepository)
    {
        $this->inventoryItemRepository = $inventoryItemRepository;
    }

    /**
     * @inheritDoc
     */
    public function execute(ChangeStockInput $input): ChangeStockResult
    {
        $inventoryItems = $this->inventoryItemRepository->findAllByProductCode($input->productCode());
        $stock = $input->stock();

        if ($inventoryItems->isEmpty())
        {
            Log::channel('inventory')->error('Inventory item with product code ' . $input->productCode() . ' not found');
        }

        $inventoryItems->each(function (InventoryItem $inventoryItem) use ($stock) {
            $inventoryItem->changeStock($stock);
            $this->inventoryItemRepository->update($inventoryItem);
        });

        return new ChangeStockResult();
    }
}
