<?php

namespace BrandStudio\Elasticsearch\Console\Operations;

use BrandStudio\Elasticsearch\ElasticClient;

class MigrateIndex extends Base
{

    public static function execute(string $model)
    {
        $index_name = $model::getIndexName();

        $params = ['body' => []];

        $items = $model::all();

        foreach($items as $item) {
            if ($item->should_index) {
                $params['body'][] = [
                    'index' => [
                        '_index' => $index_name,
                        '_id' => $item->id,
                    ]
                ];
                $params['body'][] = $item->prepareToMigrate();
            }
        }

        if (count($params['body'])) {
            $client = resolve(ElasticClient::class);
            $client->index($params);            
        }

        echo "Index {$index_name} migrated successfully\n";
    }

}
