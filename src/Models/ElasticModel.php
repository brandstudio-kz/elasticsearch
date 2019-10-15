<?php

namespace BrandStudio\Elasticsearch\Models;

use Illuminate\Database\Eloquent\Model;
use BrandStudio\Elasticsearch\Builder;
use BrandStudio\Elasticsearch\ElasticClient;

class ElasticModel extends Model
{

    public static function boot()
    {
        parent::boot();

        static::deleting(function($item) {
            $client = resolve(ElasticClient::class);
            try {
                $client->dropDocument([
                    'index' => static::getIndexName(),
                    'id' => $item->id,
                ]);
            } catch (\Exception $e) {}
        });

        static::created(function($item) {
            if ($item->should_index) {
                $client = resolve(ElasticClient::class);
                $client->indexDocument([
                    'index' => static::getIndexName(),
                    'id' => $item->id,
                    'body' => static::find($item->id)->toArray(),
                ]);
            }
        });

        static::updated(function($item) {
            $client = resolve(ElasticClient::class);
            if ($item->should_index) {
                try {
                    $client->updateDocument([
                        'index' => static::getIndexName(),
                        'id' => $item->id,
                        'body' => [
                            'doc' => static::find($item->id)->toArray(),
                        ],
                    ]);
                } catch (\Exception $e) {
                    $client->indexDocument([
                        'index' => static::getIndexName(),
                        'id' => $item->id,
                        'body' => static::find($item->id)->toArray(),
                    ]);                    
                }
            } else {
                try {
                    $client->dropDocument([
                        'index' => static::getIndexName(),
                        'id' => $item->id,
                    ]);
                } catch (\Exception $e) {}
            }
        });
    }


    public static function search(string $q = null) : Builder
    {
        return new Builder(static::class, $q);
    }

    public static function getIndexName() : string
    {
        return strtolower(class_basename(static::class))."_index";
    }

    public static $settings = [
        'number_of_shards' => 1,
        'number_of_replicas' => 0,
    ];

    public static $mappings = [
        'properties' => [
            'id' => [
                'type' => 'long',
            ],
        ]
    ];

    public static function getParams() : array
    {
        return [
            'index' => static::getIndexName(),
            'body' => [
                'settings' => static::$settings,
                'mappings' => static::$mappings,
            ],
        ];
    }

    public function getShouldIndexAttribute() : bool
    {
        return true;
    }

}
