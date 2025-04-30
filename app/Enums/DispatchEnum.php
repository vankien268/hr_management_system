<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DispatchEnum extends Enum
{
    // CustomerType
    const DISPATCH_SENDER = 1;
    const DISPATCH_RECEIVER = 0;
}
