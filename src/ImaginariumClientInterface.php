<?php

namespace ImaginariumClient;

/**
 * Interface ImaginariumClientInterface
 * @package ImaginariumClient
 */
interface ImaginariumClientInterface
{
    public function upload(array $list): array;
}
