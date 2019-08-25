<?php

namespace BrandStudio\Elasticsearch\Console\Operations;

use BrandStudio\Elasticsearch\ElasticClient;

class MigrateConfigurator extends Base
{

    public static function execute(string $name)
    {
        $configurator = self::getConfiguratorClass($name);
        $index_name = self::getIndexName($name);

        $params = $configurator::getParams();

        $client = resolve(ElasticClient::class);
        $client->createIndex($params);

        echo "Index {$index_name} created successfully\n";
    }

}
