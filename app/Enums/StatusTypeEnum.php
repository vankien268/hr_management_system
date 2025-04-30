<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusTypeEnum extends Enum
{
    const PROJECT = 0;
    const CONTRACT = 1;
    const CUSTOMER = 2;
    const DIARY_PROJECT = 3;
    const ACCEPTANCE_RECORD = 4;
    const DEPLOYMENT_RECORD = 5;
    const DISPATCHES = 6;
    const DEPLOYMENT_SCHEDULE = 7;
}
