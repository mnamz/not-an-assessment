<?php 

namespace App\Enums;

enum OrderPayment : string {
    case Paypal = 'paypal';
    case Cash = 'cash';
}
