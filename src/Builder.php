<?php

namespace BrandStudio\Elasticsearch;

class Builder
{

    protected $client;

    protected $query;

    public function __construct(ElasticClient $client, string $query)
    {
        $this->client = $client;
        $this->query = $query;
    }

    public function get()
    {
        return [];
    }

    public function paginate()
    {
        return $this->get();
    }

    public function where()
    {
        return $this;
    }

}
