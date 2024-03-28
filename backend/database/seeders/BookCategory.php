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
class BookCategory extends Enum
{
    const FICTION = 'Fiction';
    const NOVEL = 'Novel';
    const TEXT_BOOK = 'Text-Book';
    const HISTORY = 'History';
    const SCIENCE = 'Science';
    const FANTASY = 'Fantasy';
}
