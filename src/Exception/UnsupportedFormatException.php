<?php

namespace ImaginariumClient\Exception;

use Exception;

/**
 * Class UnsupportedFormatException
 * @package ImaginariumClient\Exception
 */
final class UnsupportedFormatException extends Exception implements ImaginariumExceptionInterface
{
    /**
     * UnsupportedFormatException constructor.
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        parent::__construct(sprintf('File %s has unsupported format. Only resource allowed', $fileName), 5, null);
    }
}
