<?php

namespace App\Inventory\Infrastructure\Persistence\Sitemanager\InventoryItems\Mappers;

use App\Inventory\Domain\InventoryItems\InventoryItem;
use App\Inventory\Domain\InventoryItems\Size;
use App\Inventory\Domain\InventoryItems\Stock;
use App\Inventory\Infrastructure\Persistence\EntityMapperTrait;
use App\Inventory\Infrastructure\Persistence\ModelMapperTrait;
use App\Inventory\Infrastructure\Persistence\ReflectionClassCache;
use App\Inventory\Infrastructure\Persistence\Sitemanager\InventoryItems\EloquentSitemanagerProduct;
use Carbon\CarbonImmutable;

class EloquentSitemanagerProductMapper extends InventoryItem
{
    use EntityMapperTrait;
    use ModelMapperTrait;

    protected static function reconstituteEntityCore(EloquentSitemanagerProduct $model): InventoryItem
    {
        $discountClass = ReflectionClassCache::getReflectionClass(InventoryItem::class);
        /** @var InventoryItem $entity */
        $entity = $discountClass->newInstanceWithoutConstructor();

        // TODO: Map attributes
        $entity->id = $model->id;
        $entity->productCode = $model->productnumber_internal;

        // TODO: Map all values correctly instead of dummies
        // Task 19105: Haal alle attributen van InventoryItem uit de andere tabellen van Sitemanager
        $entity->description = 'Dummy description';
        $entity->brand = $model->brandname;
        $entity->color = 'Dummy color';
        $entity->width = new Size(0, 'cm');
        $entity->length = new Size(0, 'cm');
        $entity->height = new Size(0, 'cm');
        $entity->location = 'Dummy location';
        $entity->stock = new Stock($model->stock, 0, 0);
        $entity->employeeWhoAddedInventoryItem = -1;
        $entity->soldPrice = null;
        $entity->soldAt = null;
        $entity->createdAt = CarbonImmutable::create(2022, 01, 01);
        $entity->registrationNumber = $model->id;


        // mapToEntity hasOne's


        // mapToEntities hasMany's

        return $entity;
    }

    protected static function createModelCore(InventoryItem $entity): void
    {
        $model = new EloquentSitemanagerProduct();

        // TODO: Map properties
        $model->id = $entity->id;
        $model->productnumber_internal = $entity->productCode;
        $model->brandname = $entity->brand;
        $model->stock = $entity->stock->free();

        // TODO: Save model and set identity
        $model->save();
        $entity->setIdentity($model->id);

        // mapToModel hasOne's

        // mapToModels hasMany's
    }

    protected static function updateModelCore(InventoryItem $entity, EloquentSitemanagerProduct $model): void
    {
        // TODO: Map properties
        $model->id = $entity->id;
        $model->productnumber_internal = $entity->productCode;
        $model->brandname = $entity->brand;
        $model->stock = $entity->stock->free();

        // TODO: Save model and set identity
        $model->save();
        $entity->setIdentity($model->id);

        // createOrUpdateModel hasOne's

        // createOrUpdateModels hasMany's
    }

    protected static function deleteModelCore(EloquentSitemanagerProduct $model): void
    {
        // purgeModel hasOne's

        // purgeModels hasMany's

        $model->delete();
    }

    protected static function pruneModelCore(InventoryItem $entity, EloquentSitemanagerProduct $model): void
    {
        // pruneModel hasOne's

        // pruneModel hasMany's
    }
}
