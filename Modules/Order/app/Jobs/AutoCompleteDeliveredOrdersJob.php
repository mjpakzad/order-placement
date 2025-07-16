<?php

namespace Modules\Order\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Modules\Order\Enums\OrderStatus;
use Modules\Order\Models\Order;

class AutoCompleteDeliveredOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void {
        Order::query()
            ->where('status', OrderStatus::SENT->value)
            ->where('created_at', '<=', now()->subHours(24))
            ->update(['status' => OrderStatus::DELIVERED->value]);
    }
}
