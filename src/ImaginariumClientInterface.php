<?php

namespace ImaginariumClient;

use Generator;

/**
 * Interface ImaginariumClientInterface
 * @package ImaginariumClient
 */
interface ImaginariumClientInterface
{
    /**
     * @param array $list
     * @return Generator
     */
    public function upload(array $list): Generator;
}
