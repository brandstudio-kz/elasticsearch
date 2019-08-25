<?php

namespace BrandStudio\Elasticsearch\Models;

use Illuminate\Database\Eloquent\Model;
use BrandStudio\Elasticsearch\Builder;

class ElasticModel extends Model
{

    public static function boot()
    {
        parent::boot();
    }

    public static function search(string $q = null) : Builder
    {
        return new Builder(static::getIndexName(), $q);
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
            '_all' => [
                'enabled' => true,
            ],
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

}
