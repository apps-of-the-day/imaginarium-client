<?php

namespace ImaginariumClient;

use GuzzleHttp\RequestOptions;

/**
 * Class Configurator
 * @package ImaginariumClient
 */
final class Configurator
{
    private const METHOD = 'POST';

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $token;

    /**
     * @var array
     */
    private $options = [
        RequestOptions::CONNECT_TIMEOUT => 4,
        RequestOptions::TIMEOUT => 30,
        RequestOptions::DEBUG => false,
        RequestOptions::HTTP_ERRORS => false,
        RequestOptions::VERIFY => false,
    ];

    /**
     * Configurator constructor.
     * @param string $url
     * @param string $token
     */
    public function __construct(string $url, string $token)
    {
        $this->url = $url;
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return static::METHOD;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        $token = [
            RequestOptions::HEADERS => [
                'Authorization' => $this->token
            ]
        ];

        return $this->options + $token;
    }
}
