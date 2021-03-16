<?php

namespace App\Http\Controllers;

use App\Mail\UpdateProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

class OrderController extends Controller
{
    /**
     * @param $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder($productId, $type)
    {
        DB::beginTransaction();
        try {
            $product = Product::lockForUpdate()->find($productId);
            if (!$product) {
                DB::rollBack();
                return response()->json('Invalid Product', 422);
            }
            $user = auth()->user();
            $quantity = request('quantity');
            $availableQuantity = $product->quantityAvailable();
            if (!$availableQuantity) {
                DB::rollBack();
                return response()->json('Products Sold', 422);
            }
            if ($availableQuantity < $quantity) {
                DB::rollBack();
                return response()->json('Insufficient Product', 422);
            }
            if ($product->orders->where('status', ORDER_PLACED)->isNotEmpty()) {
                DB::rollBack();
                return response()->json('Order already placed', 422);
            }
            $status = ($type == 'place') ? ORDER_PLACED : ORDER_ADD_TO_CART;
            if ($status == ORDER_PLACED) {
                $product->orders()->updateOrCreate(['user_id' => $user->id], [
                    'user_id' => $user->id,
                    'quantity' => $quantity,
                    'status' => $status,
                    'amount' => $quantity * $product->price,
                ]);
                $updateQuantity = $product->quantity - $quantity;
                $product->update(['quantity' => $updateQuantity > 0 ? $updateQuantity : 0]);
                $message = 'Order Placed';
                if ($updateQuantity < 3) {
                    $admin = User::whereHas('roles', function ($role) {
                        $role->whereName('vendor');
                    })->first();
                    Mail::to($admin->email)->send(new UpdateProduct($productId));
                }
            } else {
                $product->orders()->create([
                    'user_id' => $user->id,
                    'quantity' => $quantity,
                    'status' => $status,
                    'amount' => $quantity * $product->price,
                ]);
                $message = 'Added To Cart';
            }
            DB::commit();
            return response()->json(['status' => $message], 200);
        } catch (Throwable $exception) {
            info($exception);
            DB::rollBack();
            return response()->json('Something went wrong', 500);
        }
    }

}
