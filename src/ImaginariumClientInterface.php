<?php

namespace ImaginariumClient;

use Generator;
use ImaginariumClient\Exception\ImaginariumExceptionInterface;

/**
 * Interface ImaginariumClientInterface
 * @package ImaginariumClient
 */
interface ImaginariumClientInterface
{
    /**
     * @param array $list
     * @return $this
     *
     * @throws ImaginariumExceptionInterface
     */
    public function setFiles(array $list): self;

    /**
     * @return Generator
     *
     * @throws ImaginariumExceptionInterface
     */
    public function upload(): Generator;
}
