<?php

namespace Tests\Feature\Inventory;

use App\Inventory\Application\ChangeStock\ChangeStock;
use App\Inventory\Application\ChangeStock\ChangeStockInput;
use App\Inventory\Domain\InventoryItems\InventoryItemFactory;
use App\Inventory\Infrastructure\Persistence\InMemory\Repositories\InMemoryCollectionInventoryItemRepository;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ChangeStockTest extends TestCase
{
    protected InMemoryCollectionInventoryItemRepository $inventoryItemRepository;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->inventoryItemRepository = new InMemoryCollectionInventoryItemRepository();
    }

    /** @test */
    public function it_should_change_stock_of_inventory_item()
    {
        // Given
        $inventoryItem = InventoryItemFactory::create();
        $this->inventoryItemRepository->save($inventoryItem);
        $changedStock = $inventoryItem->stock()->current() + random_int(1, 100);

        $changeStock = new ChangeStock($this->inventoryItemRepository);
        $changeStockInput = new ChangeStockInput([
            'product_code' => $inventoryItem->productCode(),
            'stock' => $changedStock
        ]);

        // When
        $changeStockResult = $changeStock->execute($changeStockInput);

        // Then
        $foundInventoryItem = $this->inventoryItemRepository->findOneByProductCode($inventoryItem->productCode());
        self::assertEquals($foundInventoryItem->stock()->free(), $changedStock);
    }

    /** @test */
    public function it_should_log_error_when_no_inventory_items_found()
    {
        $changedStock = random_int(1, 100);
        $productCode = 'Non Existing Product Code';
        $changeStock = new ChangeStock($this->inventoryItemRepository);
        $changeStockInput = new ChangeStockInput([
            'product_code' => $productCode,
            'stock' => $changedStock
        ]);

        // Then
        Log::shouldReceive('channel')
            ->with('inventory')
            ->once()
            ->andReturnSelf();

        Log::shouldReceive('channel->error')
            ->once()
            ->with('Inventory item with product code ' . $productCode . ' not found');

        // When
        $changeStockResult = $changeStock->execute($changeStockInput);
    }
}
