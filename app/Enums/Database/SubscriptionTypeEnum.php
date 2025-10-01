<?php

namespace App\Enums\Database;

use App\Enums\EnumHelperTrait;

enum SubscriptionTypeEnum: string
{
    use EnumHelperTrait;

    case PREMIUM = 'PREMIUM';
    case FREE = 'FREE';
}
