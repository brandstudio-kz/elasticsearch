<?php

namespace BrandStudio\Elasticsearch\Configurators;

class Configurator
{

    public static function getParams() : array
    {
        return [
            'index' => static::INDEX_NAME,
            'body' => [
                'settings' => static::SETTINGS,
                'mappings' => static::MAPPINGS,
            ],
        ];
    }

}
