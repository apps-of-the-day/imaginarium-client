<?php

namespace ImaginariumClient;

use Generator;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;
use ImaginariumClient\DTO\Uploaded;
use ImaginariumClient\Exception\BadResponseException;
use ImaginariumClient\Exception\ClientException;
use ImaginariumClient\Exception\EmptySetException;
use ImaginariumClient\Exception\ImaginariumExceptionInterface;
use ImaginariumClient\Exception\UnexpectedStatusException;
use ImaginariumClient\Exception\UnsupportedFormatException;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use function GuzzleHttp\json_decode;

/**
 * Class ImaginariumClient
 * @package ImaginariumClient
 */
final class ImaginariumClient implements ImaginariumClientInterface
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
     * @var array
     */
    private $files;

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
        $this->files = [];
    }

    /**
     * @param array $list
     * @return $this
     * @throws UnsupportedFormatException
     */
    public function setFiles(array $list): self
    {
        if (0 === count($list)) {
            throw new EmptySetException();
        }

        foreach ($list as $fileName => $resource) {
            $this->files[] = ImageWrapper::wrap($fileName, $resource);
        }

        return $this;
    }

    /**
     * @return Generator
     * @throws ImaginariumExceptionInterface
     */
    public function upload(): Generator
    {
        $options = $this->configurator->getOptions();
        $options[RequestOptions::MULTIPART] = $this->files;

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
