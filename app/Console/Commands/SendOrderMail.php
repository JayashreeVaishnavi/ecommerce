<?php

namespace App\Console\Commands;

use App\Mail\MakeOrder;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendOrderMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send_mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To send mail or revert order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $orders = Order::whereStatus(ORDER_ADD_TO_CART)->where('created_at', '<', now()->subHour())->update(['is_hold', 'no']);
            $mailOrders = Order::with('product', 'user')->whereStatus(ORDER_ADD_TO_CART)->where('is_mail_sent', 'no')->get();
            if ($mailOrders) {
                foreach ($orders as $order) {
                    if ($order->product->quantity == 0) {
                        Mail::to($order->user->email)->send(new MakeOrder($order->product_id));
                        $order->update(['is_mail_sent', 'yes']);
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
        }
    }
}
