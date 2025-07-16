<?php

namespace Modules\Order\Tests\Unit;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Order\Enums\OrderStatus;
use Modules\Order\Jobs\AutoCompleteDeliveredOrdersJob;
use Modules\Order\Models\Order;
use Tests\TestCase;

class AutoCompleteDeliveredOrdersTest extends TestCase
{
    use RefreshDatabase;

    public function test_orders_older_than_24_hours_and_shipped_are_marked_as_delivered()
    {
        $order = Order::factory()->create([
            'status' => OrderStatus::SENT->value,
            'created_at' => now()->subHours(25),
        ]);

        (new AutoCompleteDeliveredOrdersJob())->handle();

        $order->refresh();
        $this->assertEquals(OrderStatus::DELIVERED, $order->status);
    }

    public function test_recent_shipped_orders_are_not_updated()
    {
        $order = Order::factory()->create([
            'status' => OrderStatus::SENT->value,
            'created_at' => now()->subHours(2),
        ]);

        (new AutoCompleteDeliveredOrdersJob())->handle();

        $order->refresh();
        $this->assertEquals(OrderStatus::SENT, $order->status);
    }

    public function test_job_is_scheduled_daily()
    {
        $schedule = resolve(Schedule::class);
        $events = collect($schedule->events());

        $jobFound = $events->contains(function ($event) {
            return str_contains($event->description ?? '', AutoCompleteDeliveredOrdersJob::class)
                || str_contains($event->command ?? '', AutoCompleteDeliveredOrdersJob::class);
        });

        $this->assertTrue($jobFound, 'AutoCompleteDeliveredOrders job is not scheduled.');
    }
}
