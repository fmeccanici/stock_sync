<?php


namespace App\Inventory\Application\DecreaseInventoryItemQuantity;

use PASVL\Validation\ValidatorBuilder;

final class DecreaseInventoryItemQuantityInput
{
    private array $inventoryItem;

    private function validate($inventoryItem)
    {
        $pattern = [
            "inventory_item" => [
                "product_code" => ":string",
                "quantity" => ":number :int"
            ]
        ];

        $validator = ValidatorBuilder::forArray($pattern)->build();

        $validator->validate($inventoryItem);
    }

    /**
     * DecreaseInventoryItemQuantityInput constructor.
     * @param $input
     */
    public function __construct($input)
    {
        $this->validate($input);
        $this->inventoryItem = $input["inventory_item"];
    }

    public function inventoryItem(): array
    {
        return $this->inventoryItem;
    }

}
