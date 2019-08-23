<?php

namespace BrandStudio\Elasticsearch;

use Elasticsearch\ClientBuilder;

class ElasticClient
{

    protected $client;

    public function __construct(array $config)
    {
        $this->client = ClientBuilder::create()->setHosts($config['hosts'])->build();
    }

    public function createIndex(array $params)
    {
        $response = $this->client->indices()->create($params);
    }

    public function dropIndex(string $name)
    {
        $params = [
            'index' => $name,
        ];
        $response = $this->client->indices()->delete($params);
    }

    public function index(array $params)
    {
        $response = $this->client->bulk($params);
    }

    public function search(array $params)
    {
        return $this->client->search($params);
    }

}
