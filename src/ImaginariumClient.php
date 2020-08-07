<?php

namespace ImaginariumClient;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;
use ImaginariumClient\DTO\Image;
use ImaginariumClient\DTO\Uploaded;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use function GuzzleHttp\json_decode;

/**
 * Class ImaginariumClient
 * @package ImaginariumClient
 */
final class ImaginariumClient implements ImaginariumClientInterface
{
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
     * @return Uploaded[]
     * @throws GuzzleException
     */
    public function upload(array $list = []): array
    {
        $options = $this->configurator->getOptions();
        $options[RequestOptions::MULTIPART] = $this->getFilesList($list);

        $this->logger->info(
            sprintf('Request to %s/%s', $this->configurator->getMethod(), $this->configurator->getUrl()),
            $options
        );

        $response =
            $this->client->request(
                $this->configurator->getMethod(), new Uri($this->configurator->getUrl()), $options
            )
        ;

        return $this->getResponse($response);
    }

    /**
     * @param array $list
     * @return array
     */
    private function getFilesList(array $list): array
    {
        if (0 === count($list)) {
            throw new InvalidArgumentException('Empty files set');
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
     * @return Uploaded[]
     */
    private function getResponse(ResponseInterface $response): array
    {
        $this->logger->info('Status code: ' . $response->getStatusCode());

        $list = json_decode($response->getBody()->getContents(), true);
        $uploaded = [];

        foreach ($list as $item) {
            $uploaded[] = new Uploaded(
                $item['filename'],
                $item['path'],
                $item['size'],
                $item['mimetype'],
                $item['encoding']
            );
        }

        return $uploaded;
    }
}
