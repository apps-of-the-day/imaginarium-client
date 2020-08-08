<?php

namespace ImaginariumClient;

use Generator;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;
use ImaginariumClient\DTO\Image;
use ImaginariumClient\DTO\Uploaded;
use ImaginariumClient\Exception\BadResponseException;
use ImaginariumClient\Exception\ClientException;
use ImaginariumClient\Exception\EmptySetException;
use ImaginariumClient\Exception\ImaginariumExceptionInterface;
use ImaginariumClient\Exception\UnexpectedStatusException;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use function GuzzleHttp\json_decode;

/**
 * Class ImaginariumClient
 * @package ImaginariumClient
 */
final class ImaginariumClient
{
    private const SUCCESS_STATUSES = [
        200,
        201,
        202
    ];

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var Configurator
     */
    private $configurator;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ImaginariumClient constructor.
     * @param ClientInterface $client
     * @param Configurator $configurator
     * @param LoggerInterface $logger
     */
    public function __construct(ClientInterface $client, Configurator $configurator, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->configurator = $configurator;
        $this->logger = $logger;
    }

    /**
     * @param array $list
     * @return Generator
     * @throws ImaginariumExceptionInterface
     */
    public function upload(array $list): Generator
    {
        $options = $this->configurator->getOptions();
        $options[RequestOptions::MULTIPART] = $this->getFilesList($list);

        $this->logger->info(
            sprintf('Request to %s/%s', $this->configurator->getMethod(), $this->configurator->getUrl()),
            $options
        );

        try {
            $response =
                $this->client->request(
                    $this->configurator->getMethod(), new Uri($this->configurator->getUrl()), $options
                )
            ;
        } catch (ClientExceptionInterface $exception) {
            throw new ClientException($exception);
        }

        $this->logger->info('Status code: ' . $response->getStatusCode());

        if (!in_array($response->getStatusCode(), self::SUCCESS_STATUSES)) {
            throw new UnexpectedStatusException($response);
        }

        foreach ($this->decode($response) as $item) {
            yield new Uploaded($item['filename'], $item['path'], $item['size'], $item['mimetype'], $item['encoding']);
        }
    }

    /**
     * @param array $list
     * @return array
     *
     * @throws EmptySetException
     */
    private function getFilesList(array $list): array
    {
        if (0 === count($list)) {
            throw new EmptySetException();
        }

        $result = [];

        foreach ($list as $image) {
            /** @var Image $image */

            $result[] = $image->get();
        }

        return $result;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     * @throws BadResponseException
     */
    private function decode(ResponseInterface $response): array
    {
        try {
            return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new BadResponseException($exception);
        }
    }
}
