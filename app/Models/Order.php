<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name', 
        'restaurant_id', 
        'method', 
        'payment', 
        'status',
        'address',
        'order_details',
        'total'
    ];

    protected $appends = [
        'created',
        'payment_method',
        'delivery_method',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function getCreatedAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('F j, Y, g:i a');
    }

    public function getPaymentMethodAttribute()
    {
        return ucfirst($this->attributes['payment']);
    }

    public function getDeliveryMethodAttribute()
    {
        return ucfirst($this->attributes['method']);
    }
}
