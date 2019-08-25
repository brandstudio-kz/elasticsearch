<?php

namespace BrandStudio\Elasticsearch\Console\Operations;

use BrandStudio\Elasticsearch\ElasticClient;

class MigrateIndex extends Base
{

    public static function execute(string $model)
    {
        $index_name = $model::getIndexName();

        $params = ['body' => []];

        $items = $model::all()->toArray();

        foreach($items as $index => $item) {
            $params['body'][] = [
                'index' => [
                    '_index' => $index_name,
                    '_id' => $item['id'],
                ]
            ];
            $params['body'][] = $item;
        }

        $client = resolve(ElasticClient::class);
        $client->index($params);

        echo "Index {$index_name} created successfully\n";
    }

}
