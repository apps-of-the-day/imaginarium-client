<?php

namespace ImaginariumClient\Exception;

use JsonException;

/**
 * Class BadResponseException
 * @package ImaginariumClient\Exception
 */
final class BadResponseException extends JsonException implements ImaginariumExceptionInterface
{
    /**
     * BadResponseException constructor.
     * @param JsonException $exception
     */
    public function __construct(JsonException $exception)
    {
        parent::__construct($exception->getMessage(), 3, null);
    }
}