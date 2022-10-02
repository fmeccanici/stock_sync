<?php

namespace App\Inventory\Infrastructure\Persistence\Sitemanager\InventoryItems;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $productnumber_internal
 * @property int $fsm_website_product_id
 * @property int $stock
 */
class EloquentSitemanagerProductOption extends Model
{
    protected $table = 'fsm_website_product_option';
    protected $connection = 'sitemanager';
    public $timestamps = false;

    public function product()
    {
        return $this->hasOne(EloquentSitemanagerProduct::class, 'fsm_website_product_id');
    }
}
