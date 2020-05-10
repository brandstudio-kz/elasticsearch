<?php

namespace BrandStudio\Elasticsearch;

class Builder
{

    protected $client;
    protected $model;

    protected $query = [];
    protected $model_query;

    public function __construct(string $model, string $q = '', $model_query = null)
    {
        $this->client = resolve(ElasticClient::class);

        $this->model = $model;

        $this->query = [
            '_source' => ['id'],
            'index' => $this->model::getIndexName(),
            'body' => $this->model::getSearchQuery($q)
        ];

        $this->model_query = $model_query ?? $this->model::query();
    }

    public function query()
    {
        $response = $this->client->search($this->query);

        $ids = array_map(
            function($item) {
                return $item['_id'];
            }, $response['hits']['hits']
        );

        return $this->model_query->whereIn('id', $ids);
    }

}
