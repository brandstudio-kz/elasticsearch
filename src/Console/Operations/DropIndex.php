<?php

namespace BrandStudio\Elasticsearch\Console\Operations;

use BrandStudio\Elasticsearch\ElasticClient;

class DropIndex extends Base
{

    public static function execute(string $model)
    {
        $index_name = $model::getIndexName();

        $client = resolve(ElasticClient::class);
        $client->dropIndex($index_name);

        echo "{$index_name} deleted successfully!\n";
    }

}
