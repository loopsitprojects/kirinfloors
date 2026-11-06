<?php

namespace Tests\Feature;

use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteOrderTest extends TestCase
{
    use RefreshDatabase;

    private function orderWithItem(): Order
    {
        $product = Product::create(['name' => 'Ashford', 'category' => 'TIMBERLINE', 'description' => 'd', 'price' => 1, 'image' => 'x.jpg']);
        $order = Order::create(['name' => 'Test', 'email' => 'test@example.com', 'city' => 'Colombo', 'status' => 'pending']);
        OrderItem::create(['order_id' => $order->id, 'product_id' => $product->id, 'quantity' => 100, 'price' => 100]);

        return $order;
    }

    public function test_order_with_items_can_be_deleted_and_takes_its_items_with_it(): void
    {
        $order = $this->orderWithItem();

        $order->delete();

        $this->assertSame(0, Order::count());
        $this->assertSame(0, OrderItem::count());
        $this->assertSame(1, Product::count());
    }

    public function test_bulk_delete_in_the_admin_panel_works(): void
    {
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $orders = [$this->orderWithItem(), $this->orderWithItem()];

        Livewire::test(ListOrders::class)
            ->selectTableRecords($orders)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertNotified();

        $this->assertSame(0, Order::count());
        $this->assertSame(0, OrderItem::count());
    }
}
