<?php

namespace ImaginariumClient;

use ImaginariumClient\Exception\BadResponseException;
use ImaginariumClient\Exception\UnsupportedFormatException;
use function GuzzleHttp\Psr7\stream_for;

/**
 * Class ImageWrapper
 * @package ImaginariumClient
 */
final class ImageWrapper
{
    /**
     * @param string $name
     * @param resource $resource
     * @param string $fieldName
     * @return array
     * @throws UnsupportedFormatException
     */
    public static function wrap(string $name, $resource, string $fieldName = 'images'): array
    {
        if (!is_resource($resource)) {
            throw new UnsupportedFormatException($name);
        }

        return
            [
                'name'      => $fieldName,
                'contents'  => $resource,
                'filename'  => $name,
            ]
        ;
    }
}
