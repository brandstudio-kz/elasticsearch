<?php

namespace BrandStudio\Elasticsearch;

class Builder
{

    protected $client;
    protected $index_name;

    protected $query_string = [];
    protected $must = [];
    protected $must_not = [];
    protected $should = [];
    protected $filter = [];

    public function __construct(string $index_name, string $q = null)
    {
        $this->index_name = $index_name;
        $this->client = resolve(ElasticClient::class);

        if (is_string($q)) {
            $this->query_string['query'] = $q;
        }
    }

    public function get()
    {
        $params = $this->getQuery();
        $response = $this->client->search($params);
        dd($response);
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
            'index' => $this->index_name,
            // 'body' => [
            //     'query' => [
            //         'query_string' => $this->query_string,
            //         'bool' => [
            //             'must' => $this->must,
            //             'must_not' => $this->must_not,
            //             'should' => $this->should,
            //             'filter' => $this->filter,
            //         ],
            //     ],
            // ],
        ];
    }

}
