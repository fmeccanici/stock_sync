<?php

namespace App\Inventory\Infrastructure\Persistence\Sitemanager\Repositories;

use App\Inventory\Domain\Exceptions\InventoryItemNotFoundException;
use App\Inventory\Domain\InventoryItems\InventoryItem;
use App\Inventory\Domain\InventoryItems\InventoryItemAnalytics;
use App\Inventory\Domain\Repositories\DestinationInventoryItemRepositoryInterface;
use App\Inventory\Domain\Repositories\SourceInventoryItemRepositoryInterface;
use App\Inventory\Infrastructure\Persistence\Sitemanager\InventoryItems\EloquentSitemanagerProduct;
use App\Inventory\Infrastructure\Persistence\Sitemanager\InventoryItems\EloquentSitemanagerProductOption;
use App\Inventory\Infrastructure\Persistence\Sitemanager\InventoryItems\EloquentSitemanagerProductOrProductOption;
use App\Inventory\Infrastructure\Persistence\Sitemanager\InventoryItems\Mappers\EloquentSitemanagerProductMapper;
use App\Inventory\Infrastructure\Persistence\Sitemanager\InventoryItems\Mappers\EloquentSitemanagerProductOptionMapper;
use Carbon\CarbonImmutable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SitemanagerInventoryItemRepository implements SourceInventoryItemRepositoryInterface, DestinationInventoryItemRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function list(array $listOptions = []): LengthAwarePaginator
    {
        // TODO: Implement list() method.
    }

    /**
     * @inheritDoc
     */
    public function save(InventoryItem $inventoryItem): InventoryItem
    {

    }

    /**
     * @inheritDoc
     */
    public function saveMultiple(Collection $inventoryItems): void
    {
        // TODO: Implement addMultiple() method.
    }

    /**
     * @inheritDoc
     */
    public function findOneByRegistrationNumber(int|string $registrationNumber): ?InventoryItem
    {
        // TODO: Implement findOneByRegistrationNumber() method.
    }

    /**
     * @inheritDoc
     */
    public function findAllByRegistrationNumbers(array $registrationNumbers): Collection
    {
        // TODO: Implement findAllByRegistrationNumbers() method.
    }

    /**
     * @inheritDoc
     */
    public function findAll(bool $withDesiredStock = true): Collection
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @inheritDoc
     */
    public function removeByRegistrationNumbers(array $registrationNumbers): void
    {
        // TODO: Implement removeByRegistrationNumbers() method.
    }

    /**
     * @inheritDoc
     */
    public function update(InventoryItem $inventoryItem): void
    {
        $productCode = $inventoryItem->productCode();

        EloquentSitemanagerProductOption::query()
            ->where('productnumber_internal', $productCode)
            ->update([
                'stock' => max(0, $inventoryItem->stock()->current())
            ]);

        EloquentSitemanagerProduct::query()
            ->where('productnumber_internal', $productCode)
            ->update([
                'stock' => max(0, $inventoryItem->stock()->current())
            ]);
    }

    /**
     * @inheritDoc
     * @throws InventoryItemNotFoundException
     */
    public function findOneByProductCode(string $productCode): ?InventoryItem
    {
        $sitemanagerProductOption = EloquentSitemanagerProductOption::query()->where('productnumber_internal', $productCode)->first();

        if ($sitemanagerProductOption !== null)
        {
            return EloquentSitemanagerProductOptionMapper::reconstituteEntity($sitemanagerProductOption);
        }

        $sitemanagerProduct = EloquentSitemanagerProduct::query()->where('productnumber_internal', $productCode)->first();

        return EloquentSitemanagerProductMapper::reconstituteEntity($sitemanagerProduct);
    }

    public function delete(InventoryItem $inventoryItem): void
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param string $productCode
     * @return array
     * @throws InventoryItemNotFoundException
     */
    protected function getProductAndProductOptionId(string $productCode): array
    {
        $productOrProductOption = EloquentSitemanagerProductOrProductOption::query()->where('productnumber_internal', $productCode)->first();

        if (!$productOrProductOption) {
            throw new InventoryItemNotFoundException('No product or product option found with product code ' . $productCode);
        }

        $productOptionId = $productOrProductOption->fsm_website_product_option_id;
        $productId = $productOrProductOption->fsm_website_id;

        return array($productOptionId, $productId);
    }

    public function findAllByType(string $type): Collection
    {
        // TODO: Implement findAllByType() method.
    }

    public function findAllByProductCode(string $productCode): Collection
    {
        return EloquentSitemanagerProductOptionMapper::reconstituteEntities(
            EloquentSitemanagerProductOption::query()->where('productnumber_internal', $productCode)->get()
        )->push(...EloquentSitemanagerProductMapper::reconstituteEntities(
            EloquentSitemanagerProduct::query()->where('productnumber_internal', $productCode)->get())
        );
    }

    public function getAnalytics(CarbonImmutable $startRangeDate = null, CarbonImmutable $endRangeDate = null, string $type = null): ?InventoryItemAnalytics
    {
        // TODO: Implement getStatistics() method.
    }

    public function findAllAvailableByProductCode(string $productCode): Collection
    {
        // TODO: Implement findAllAvailableByProductCode() method.
    }

    public function findAllByTagAndSupplierId(string $tag, int $supplierId): Collection
    {
        // TODO: Implement findAllBySupplierAndTag() method.
    }
}
