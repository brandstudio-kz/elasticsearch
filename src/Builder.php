<?php

namespace BrandStudio\Elasticsearch;

class Builder
{

    protected $client;
    protected $model;

    protected $query = [];
    protected $q;

    public function __construct(string $model, string $q = '', Int $size)
    {
        $this->client = resolve(ElasticClient::class);

        $this->model = $model;
        $this->q = $q;

        $this->query = [
            '_source' => ['id'],
            'index' => $this->model::getIndexName(),
            'body' => [
                'query' => $this->model::getSearchQuery($q),
            ],
            'size' => $size,
        ];
    }

    protected function search()
    {
        $response = $this->client->search($this->query);

        return array_map(
            function($item) {
                return [
                    'id' => $item['_id'],
                    'score' => $item['_score']
                ];
            }, $response['hits']['hits']
        );
    }

    public function get($query = null)
    {
        $hits = \Cache::remember($this->model::getIndexName()."_{$this->q}", config('brandstudio.elasticsearch.cache_lifetime'), function() {
            return $this->search();
        });

        if (!$query) {
            return $hits;
        }

        $ids = array_column($hits, 'id');

        return $query->whereIn('id', $ids)->orderByRaw(\DB::raw("FIELD(id, ".implode(',', $ids).")"));
    }

}
