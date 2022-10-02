<?php

namespace App\Inventory\Infrastructure\Persistence\Sitemanager\InventoryItems;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string productnumber_internal
 * @property int $fsm_website_product_id
 * @property int $fsm_website_product_option_id
 */
class EloquentSitemanagerProductOrProductOption extends Model
{
    protected $table = 'view_product_or_product_option_external';
    protected $connection = 'sitemanager';

    public function product()
    {
        return $this->hasOne(EloquentSitemanagerProduct::class, 'fsm_website_product_id');
    }

    public function productOption()
    {
        return $this->hasOne(EloquentSitemanagerProductOption::class, 'fsm_website_product_option_id');
    }
}
