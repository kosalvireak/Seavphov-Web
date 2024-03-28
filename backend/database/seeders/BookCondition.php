<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The Status enum.
 *
 * @method static self IN_PROGRESS()
 * @method static self COMPLETE()
 * @method static self FAILED()
 */
class BookCondition extends Enum
{

    const AS_NEW = 'As New';
    const GOOD = 'Good';
    const WELL_WORN = 'Well-worn';
}
