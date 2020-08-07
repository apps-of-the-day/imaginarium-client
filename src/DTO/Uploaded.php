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
     * @var string
     */
    private $hash;

    /**
     * Uploaded constructor.
     * @param string $name
     * @param string $path
     * @param string $hash
     */
    public function __construct(string $name, string $path, string $hash)
    {
        $this->name = $name;
        $this->path = $path;
        $this->hash = $hash;
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
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }
}
