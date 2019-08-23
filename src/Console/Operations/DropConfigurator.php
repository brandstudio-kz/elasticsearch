<?php

namespace BrandStudio\Elasticsearch\Console\Operations;

use BrandStudio\Elasticsearch\ElasticClient;

class DropConfigurator extends Base
{

    public static function execute(string $name)
    {
        $index_name = self::getIndexName($name);

        $client = resolve(ElasticClient::class);
        $client->dropIndex($index_name);

        echo "{$index_name} deleted successfully!\n";
    }

}
