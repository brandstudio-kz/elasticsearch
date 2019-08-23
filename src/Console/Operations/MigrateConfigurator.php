<?php

namespace BrandStudio\Elasticsearch\Console\Operations;

use BrandStudio\Elasticsearch\ElasticClient;

class MigrateConfigurator extends Base
{

    public static function execute(string $name)
    {
        $configurator = self::getConfiguratorClass($name);
        $index_name = self::getIndexName($name);

        $params = [
            'index' => $index_name,
            'body' => [
                'settings' => $configurator::SETTINGS,
                'mappings' => $configurator::MAPPINGS,
            ],
        ];

        $client = resolve(ElasticClient::class);
        $client->createIndex($params);

        echo "Index {$index_name} created successfully\n";
    }

}
