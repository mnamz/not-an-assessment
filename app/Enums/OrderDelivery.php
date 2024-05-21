<?php 

namespace App\Enums;

enum OrderDelivery : string {
    case Pickup = 'pickup';
    case Delivery = 'delivery';
}
