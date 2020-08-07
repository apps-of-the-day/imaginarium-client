<?php

namespace ImaginariumClient\Exception;

use InvalidArgumentException;

/**
 * Class EmptySetException
 * @package ImaginariumClient\Exception
 */
final class EmptySetException extends InvalidArgumentException implements ImaginariumExceptionInterface
{
    /**
     * EmptySetException constructor.
     */
    public function __construct()
    {
        parent::__construct('Empty files set', 1, null);
    }
}