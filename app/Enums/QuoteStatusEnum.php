<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class QuoteStatusEnum extends Enum
{
    const NOT_APPROVED_YET = 0;
    const APPROVED = 1;
    const CANCELLED = 2;
}
