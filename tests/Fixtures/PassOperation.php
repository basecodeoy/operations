<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Fixtures;

use BaseCodeOy\Operations\Operations\AbstractOneTimeOperation;

final class PassOperation extends AbstractOneTimeOperation
{
    #[\Override()]
    public function process(): void
    {
        //
    }
}