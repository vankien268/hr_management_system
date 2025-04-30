<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserEnum extends Enum
{
    const LOGIN_NUMBER = 5;
    const BLOCK = 0;
    const ACTIVE = 1;
    const RESET_LOGIN_NUMBER = 0;
}
