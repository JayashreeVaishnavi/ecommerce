<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'price' => 'float',
    ];

    protected $fillable = ['name', 'price', 'quantity', 'picture'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function holdOrders()
    {
        return $this->orders()->whereStatus(ORDER_ADD_TO_CART);
    }

    /**
     * @return int|mixed
     */
    public function quantityAvailable()
    {
        $quantity = $this->quantity - $this->holdOrders()->where('is_hold', 'yes')->sum('quantity');
        if ($quantity > 0) {
            return $quantity;
        }
        return 0;
    }
}
