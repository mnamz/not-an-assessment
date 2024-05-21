<?php 

namespace App\Enums;

enum UserStatus : string {
    case Pending = 'Pending';
    case Active = 'Active';
    case Inactive = 'Inactive';
}
