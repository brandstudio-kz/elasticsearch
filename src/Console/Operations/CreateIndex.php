<?php

namespace BrandStudio\Elasticsearch\Console\Operations;

use BrandStudio\Elasticsearch\ElasticClient;

class CreateIndex extends Base
{

    public static function execute(string $model)
    {
        $params = $model::getParams();

        $client = resolve(ElasticClient::class);
        $client->createIndex($params);

        echo "{$model::getIndexName()} created successfully!\n";
    }

}
