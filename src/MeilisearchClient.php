<?php

namespace Meilisearch\Scout;

use MeiliSearch\Client;

class MeilisearchClient
{
    private $client;

    public function __construct()
    {
        $httpClient = config('meilisearch.httpclient') ? app(config('meilisearch.httpclient')) : null;
        $requestFactory = config('meilisearch.requestfactory') ? app(config('meilisearch.requestfactory')) : null;
        $streamFactory = config('meilisearch.streamfactory') ? app(config('meilisearch.streamfactory')) : null;

        $this->client = new Client(config('meilisearch.host'), config('meilisearch.key'), $httpClient, $requestFactory, $streamFactory);
    }

    public function getClient()
    {
        return $this->client;
    }
}
