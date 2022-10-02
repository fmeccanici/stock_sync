<?php


namespace App\Inventory\Presentation\Http\Api;


use App\Inventory\Domain\Repositories\InventoryItemRepositoryInterface;
use App\Inventory\Infrastructure\Webhooks\WebhookManager;
use JetBrains\PhpStorm\ArrayShape;

class InventoryItemController
{
    protected InventoryItemRepositoryInterface $inventoryItemRepository;

    public function __construct()
    {
        $this->inventoryItemRepository = App::make(InventoryItemRepositoryInterface::class);
    }

    public function handleWebhook(Request $request, string $webhookName)
    {
        WebhookManager::handle($request, $webhookName);
    }
}
