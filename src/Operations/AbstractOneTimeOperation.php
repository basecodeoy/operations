<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Operations\Operations;

abstract class AbstractOneTimeOperation
{
    public function __construct(
        private readonly string $operationName,
    ) {}

    /**
     * Determine if the operation is being processed asynchronously.
     */
    public function isAsync(): bool
    {
        return false;
    }

    /**
     * The queue that the job will be dispatched to.
     */
    public function getQueue(): string
    {
        return 'default';
    }

    /**
     * A tag name, that this operation can be filtered by.
     */
    public function getTags(): array
    {
        return [];
    }

    public function getName(): string
    {
        return $this->operationName;
    }

    abstract public function process(): void;
}
