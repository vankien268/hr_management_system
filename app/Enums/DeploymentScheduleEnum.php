<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DeploymentScheduleEnum extends Enum
{
    const CA_SANG = 0; // ca sáng
    const CA_CHIEU = 1; // ca chiều
    const CA_TOI = 2; // ca tối
    const ARRAY_SHIFT = [
        self::CA_SANG => 'Ca sáng',
        self::CA_CHIEU => 'Ca chiều',
        self::CA_TOI => 'Ca tối'
    ]; // ca làm việc
}
