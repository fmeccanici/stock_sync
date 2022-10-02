<?php


namespace App\Inventory\Application\ChangeStock;

use HomeDesignShops\LaravelDdd\Support\Input;
use Illuminate\Support\Arr;

final class ChangeStockInput extends Input
{
    /**
     * @var array The PASVL validation rules
     */
    protected $rules = [
        'product_code' => ':string',
        'stock' => ':number :int'
    ];

    protected int $stock;
    protected string $productCode;

    /**
     * ChangeStockInput constructor.
     */
    public function __construct($input)
    {
        $this->validate($input);
        $this->productCode = Arr::get($input, 'product_code');
        $this->stock = Arr::get($input, 'stock');
    }

    public function productCode(): string
    {
        return $this->productCode;
    }

    public function stock(): int
    {
        return $this->stock;
    }
}
