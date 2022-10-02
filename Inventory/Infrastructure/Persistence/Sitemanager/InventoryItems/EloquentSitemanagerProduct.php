<?php

namespace App\Inventory\Infrastructure\Persistence\Sitemanager\InventoryItems;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $brandname
 * @property string $productnumber_internal
 * @property bool $infinite_stock
 * @property int $stock
 */
class EloquentSitemanagerProduct extends Model
{
    protected $table = 'fsm_website_product';
    protected $connection = 'sitemanager';
    public $timestamps = false;

    public function productOption()
    {
        return $this->hasOne(EloquentSitemanagerProductOption::class, 'fsm_website_product');
    }
}
