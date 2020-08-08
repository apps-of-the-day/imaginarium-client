<?php

namespace ImaginariumClient\Exception;

use Exception;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class ClientException
 * @package ImaginariumClient\Exception
 */
final class ClientException extends Exception implements ImaginariumExceptionInterface
{
    /**
     * ClientException constructor.
     * @param ClientExceptionInterface $exception
     */
    public function __construct(ClientExceptionInterface $exception)
    {
        parent::__construct($exception->getMessage(), 4, null);
    }
}
