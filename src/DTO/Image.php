<?php

namespace ImaginariumClient\DTO;

use SplFileInfo;

/**
 * Class Image
 * @package ImaginariumClient\DTO
 */
final class Image
{
    /**
     * @var SplFileInfo
     */
    private $file;

    /**
     * Image constructor.
     * @param SplFileInfo $file
     */
    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;
    }

    /**
     * @param string $fieldName
     * @return array
     */
    public function get(string $fieldName = 'image'): array
    {
        return
        [
            'name'      => $fieldName,
            'contents'  => fopen($this->file->getPathname(), 'rb'),
            'filename'  => $this->file->getFilename(),
        ];
    }
}
