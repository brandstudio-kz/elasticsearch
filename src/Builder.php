<?php

namespace BrandStudio\Elasticsearch;

class Builder
{

    protected $client;
    protected $model;

    protected $must = [];
    protected $must_not = [];
    protected $should = [];
    protected $filter = [];
    protected $query = [];

    public function __construct(string $model, string $q = '')
    {
        $this->model = $model;
        $this->client = resolve(ElasticClient::class);

        $this->query = [
            'index' => $this->model::getIndexName(),
            'body' => $this->model::getSearchQuery($q)
        ];
    }

    public function get($is_paginate = false)
    {
        $response = $this->client->search($this->query);

        $data = array_map(
            function($item) {
                $model = new $this->model;
                $model->prepareToResponse($item['_source'] ?? []);
                // $model->fill($item['_source'] ?? []);
                return $model;
            }, $response['hits']['hits']
        );

        if ($is_paginate) {
            return [
                'total' => $response['hits']['total']['value'],
                'data' => $data,
            ];
        }

        return $data;
    }

    public function paginate($per_page = 10)
    {
        $current_page = request()->page ?? 1;

        $this->query['size'] = $per_page;
        $this->query['from'] = $per_page * ($current_page-1);

        $data = $this->get(true);

        $data['current_page'] = $current_page;
        $data['per_page'] = $per_page;
        $data['last_page'] = ceil($data['total']/$per_page);

        return $data;
    }

    public function orderBy(string $field, string $order) {
        if (!isset($this->query['sort'])) {
            $this->query['sort'] = [];
        }
        $this->query['sort'][] = "{$field}:{$order}";
        return $this;
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

}
