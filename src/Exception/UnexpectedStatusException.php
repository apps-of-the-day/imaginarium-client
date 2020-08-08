<?php

namespace ImaginariumClient\Exception;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class UnexpectedStatusException
 * @package ImaginariumClient\Exception
 */
final class UnexpectedStatusException extends InvalidArgumentException implements ImaginariumExceptionInterface
{
    /**
     * UnexpectedStatusException constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct(sprintf('Status %s unexpected', $response->getStatusCode()), 2, null);
    }
}