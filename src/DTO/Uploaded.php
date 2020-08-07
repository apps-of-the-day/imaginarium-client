<?php

namespace ImaginariumClient\DTO;

/**
 * Class Uploaded
 * @package ImaginariumClient\DTO
 */
final class Uploaded
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $path;

    /**
     * @var int
     */
    private $size;

    /**
     * @var string
     */
    private $mineType;

    /**
     * @var string
     */
    private $encoding;

    /**
     * Uploaded constructor.
     * @param string $name
     * @param string $path
     * @param int $size
     * @param string $mineType
     * @param string $encoding
     */
    public function __construct(string $name, string $path, int $size, string $mineType, string $encoding)
    {
        $this->name = $name;
        $this->path = $path;
        $this->size = $size;
        $this->mineType = $mineType;
        $this->encoding = $encoding;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getMineType(): string
    {
        return $this->mineType;
    }

    /**
     * @return string
     */
    public function getEncoding(): string
    {
        return $this->encoding;
    }
}
