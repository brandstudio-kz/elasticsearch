<?php

namespace BrandStudio\Elasticsearch;

class Builder
{

    protected $client;
    protected $model;

    protected $query_string;
    protected $must = [];
    protected $must_not = [];
    protected $should = [];
    protected $filter = [];

    public function __construct(string $model, string $q = null)
    {
        $this->model = $model;
        $this->client = resolve(ElasticClient::class);

        if (is_string($q)) {
            $this->query_string = $q;
        }
    }

    public function get()
    {
        $params = $this->getQuery();
        $response = $this->client->search($params);
        // dd($params);
        return array_map(
            function($item) {
                return new $this->model($item['_source'] ?? []);
            }, $response['hits']['hits']
        );
    }

    public function paginate()
    {
        return $this->get();
    }

    public function where() : self
    {
        return $this;
    }

    public function whereNot() : self
    {
        return $this;
    }

    public function should() : self
    {
        return $this;
    }

    public function filter(string $field, $value) : self
    {
        $this->filter['term'][$field] = $value;
        return $this;
    }

    protected function getQuery() : array
    {
        return [
            'index' => $this->model::getIndexName(),
            'body' => [
                'query' => [
                    'query_string' => [
                        'query' => $this->query_string,
                        'fuzziness' => '6',
                        'fuzzy_max_expansions' => 100,
                        'fuzzy_prefix_length' => 10,
                        'minimum_should_match' => '1'
                    ]
                ],
            ],
        ];
    }

}
