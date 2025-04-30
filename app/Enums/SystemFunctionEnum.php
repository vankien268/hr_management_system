<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class SystemFunctionEnum extends Enum
{
    const TYPE_SYSTEM_FUNCTION = 0;
    const TYPE_PROJECT_FUNCTION = 1;
    const STATUS_ACTIVE = 1;

}
